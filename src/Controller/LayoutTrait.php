<?php

namespace App\Controller;

/**
 * Provides shared layout variables (sidebar, topbar) for all page controllers.
 * Use: `use LayoutTrait;` and call `$this->layoutArgs()` in render().
 */
trait LayoutTrait
{
    private function layoutArgs(): array
    {
        // TODO: Replace static values with real data from repositories / security.
        return [
            'appName'           => 'DevFlow',
            'appVersion'        => 'v2.4.0 Symfony',
            'environment'       => 'Symfony 6.4 (dev)',
            'notificationCount' => 0,
            'notesCount'        => 0, // inject NoteRepository and call ->count([])
            'projects'          => [
                ['name' => 'Acme Corp API',    'color' => 'emerald'],
                ['name' => 'Legacy Migration', 'color' => 'accent'],
                ['name' => 'DevOps Tooling',   'color' => 'orange'],
            ],
            'user' => [
                'name'      => 'Blizzard-fs',
                'role'      => 'Administrator',
                'avatarUrl' => 'https://i.pravatar.cc/150',
            ],
        ];
    }
}
