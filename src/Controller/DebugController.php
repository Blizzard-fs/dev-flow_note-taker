<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DebugController
{
    #[Route('/debug', name: 'debug')]
    public function debug(): Response
    {
        return new Response(
            '<pre>' . implode("\n", array_filter(
                explode(',', ini_get('extension_dir') . "\n" . phpversion()),
            )) . "\n" . (extension_loaded('pdo_pgsql') ? 'pdo_pgsql: YES' : 'pdo_pgsql: NO') . '</pre>'
        );
    }
}
