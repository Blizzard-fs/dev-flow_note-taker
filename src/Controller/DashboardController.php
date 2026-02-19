<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [

            // ── App meta ────────────────────────────────────────────
            'appName'           => 'DevFlow',
            'appVersion'        => 'v2.4.0 Symfony',
            'environment'       => 'Symfony 6.4 (prod)',
            'notificationCount' => 3,

            // ── Logged-in user ───────────────────────────────────────
            // Replace with $this->getUser() once security is configured
            'user' => [
                'name'      => 'Alex Developer',
                'role'      => 'Senior Engineer',
                'avatarUrl' => 'https://i.pravatar.cc/150?u=alex',
            ],

            // ── Sidebar counters ─────────────────────────────────────
            'notesCount' => 12,

            // ── Sidebar projects ─────────────────────────────────────
            // color: 'emerald' | 'accent' | 'orange'
            'projects' => [
                ['name' => 'Acme Corp API',   'color' => 'emerald'],
                ['name' => 'Legacy Migration', 'color' => 'accent'],
                ['name' => 'DevOps Tooling',   'color' => 'orange'],
            ],

            // ── Metric cards ─────────────────────────────────────────
            // trend: 'up' | 'down' | 'flat'
            // color: 'primary' | 'accent' | 'orange'
            'metrics' => [
                [
                    'label'      => 'Total Notes',
                    'value'      => '1,248',
                    'subtext'    => '+142 this week',
                    'icon'       => 'note_stack',
                    'trend'      => 'up',
                    'trendValue' => '12%',
                    'color'      => 'primary',
                ],
                [
                    'label'      => 'Total Clients',
                    'value'      => '42',
                    'subtext'    => '3 new onboarded',
                    'icon'       => 'group',
                    'trend'      => 'up',
                    'trendValue' => '2%',
                    'color'      => 'accent',
                ],
                [
                    'label'      => 'Active Projects',
                    'value'      => '8',
                    'subtext'    => '2 deadlines approaching',
                    'icon'       => 'bolt',
                    'trend'      => 'flat',
                    'trendValue' => '0%',
                    'color'      => 'orange',
                ],
            ],

            // ── Bar chart (notes per day) ─────────────────────────────
            // height: 0–100 (%), active: highlights the current/peak bar
            'weeklyBars' => [
                ['day' => 'Mon', 'height' => 45, 'count' => 45, 'active' => false],
                ['day' => 'Tue', 'height' => 82, 'count' => 82, 'active' => true],
                ['day' => 'Wed', 'height' => 30, 'count' => 30, 'active' => false],
                ['day' => 'Thu', 'height' => 65, 'count' => 65, 'active' => false],
                ['day' => 'Fri', 'height' => 55, 'count' => 55, 'active' => false],
                ['day' => 'Sat', 'height' => 20, 'count' => 20, 'active' => false],
                ['day' => 'Sun', 'height' => 15, 'count' => 15, 'active' => false],
            ],

            // ── Activity log summary ──────────────────────────────────
            'activityLog' => [
                'totalHours' => '89h',
            ],

            // ── Recent notes ──────────────────────────────────────────
            // color: 'indigo' | 'orange' | 'emerald' | 'blue'
            'recentNotes' => [
                [
                    'title'   => 'Meeting with Acme Corp',
                    'excerpt' => 'Discussed the API rate limiting strategy and new Symfony bundles...',
                    'icon'    => 'meeting_room',
                    'tag'     => 'Acme',
                    'timeAgo' => '2h ago',
                    'color'   => 'indigo',
                ],
                [
                    'title'   => 'Symfony Config Update',
                    'excerpt' => 'Updated yaml configuration for doctrine migrations to support...',
                    'icon'    => 'terminal',
                    'tag'     => 'Internal',
                    'timeAgo' => '5h ago',
                    'color'   => 'orange',
                ],
                [
                    'title'   => 'Refactoring User Auth',
                    'excerpt' => 'Implementing the new Guard authenticator system for...',
                    'icon'    => 'code',
                    'tag'     => 'Project X',
                    'timeAgo' => 'Yesterday',
                    'color'   => 'emerald',
                ],
                [
                    'title'   => 'Fixing memory leak in worker',
                    'excerpt' => 'Identified circular reference in the message handler service...',
                    'icon'    => 'bug_report',
                    'tag'     => 'Maintenance',
                    'timeAgo' => '2 days ago',
                    'color'   => 'blue',
                ],
            ],

            // ── Top client card ───────────────────────────────────────
            'topClient' => [
                'name'        => 'Acme Corp',
                'description' => 'Enterprise Retail Solution',
                'totalHours'  => '142h',
                'notesCount'  => 89,
            ],
        ]);
    }
}
