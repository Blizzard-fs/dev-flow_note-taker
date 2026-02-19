<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/client')]
final class ClientController extends AbstractController
{
    use LayoutTrait;

    /**
     * Lists all clients.
     * Passes the New-Client form so the modal is ready on page load.
     */
    #[Route(name: 'app_client_index', methods: ['GET', 'POST'])]
    public function index(EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form   = $this->createForm(ClientType::class, $client, [
            'action' => $this->generateUrl('app_client_new'),
        ]);

        return $this->render('client/index.html.twig', array_merge(
            $this->layoutArgs(),
            [
                'clients' => $em->getRepository(Client::class)->findAll(),
                'form'    => $form,
            ]
        ));
    }

    /**
     * Handles POST from the New Client modal form.
     * On GET, redirects to index (modal auto-opens via JS).
     */
    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form   = $this->createForm(ClientType::class, $client, [
            'action' => $this->generateUrl('app_client_new'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();
            $this->addFlash('success', 'Client created successfully.');
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        // AJAX request from modal → return only the form partial
        if ($request->isXmlHttpRequest()) {
            return $this->render('client/_form.html.twig', [
                'form'         => $form,
                'button_label' => 'Create Client',
            ]);
        }

        return $this->render('client/new.html.twig', array_merge(
            $this->layoutArgs(),
            ['client' => $client, 'clients' => $em->getRepository(Client::class)->findAll(), 'form' => $form]
        ));
    }

    /**
     * Shows a single client.
     */
    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', array_merge(
            $this->layoutArgs(),
            ['client' => $client]
        ));
    }

    /**
     * Edit a client.
     * When called via AJAX (modal), returns only the form HTML partial.
     * On direct page load, returns the full index layout with the modal open.
     */
    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ClientType::class, $client, [
            'action' => $this->generateUrl('app_client_edit', ['id' => $client->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Client updated successfully.');
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        // AJAX request from the modal JS → return only the form partial
        if ($request->isXmlHttpRequest()) {
            return $this->render('client/_form.html.twig', [
                'form'         => $form,
                'button_label' => 'Save Changes',
            ]);
        }

        // Direct URL visit → full page with modal open
        return $this->render('client/edit.html.twig', array_merge(
            $this->layoutArgs(),
            [
                'client'  => $client,
                'clients' => $em->getRepository(Client::class)->findAll(),
                'form'    => $form,
            ]
        ));
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Client deleted.');
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
