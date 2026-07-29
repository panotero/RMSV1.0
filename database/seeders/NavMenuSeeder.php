<?php

namespace Database\Seeders;

use App\Models\NavMenu;
use Illuminate\Database\Seeder;
use RuntimeException;

class NavMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Top-level items use parent_title => null. Children resolve their
     * parent's actual row id by title lookup at seed time instead of a
     * hardcoded id literal - a hardcoded id drifts out of sync the moment
     * rows are added/removed/reordered through the live Menus admin page.
     * List each parent before its children below; the lookup requires it.
     *
     * `icon` is a key into the nav_icons table (see NavIconSeeder), not a
     * FontAwesome class - that library was never actually loaded in this
     * app, so the old "fas fa-x" values here never rendered anything.
     */
    public function run(): void
    {
        $menu_array = [
            [
                'title' => 'Dashboard',
                'icon' => 'home',
                'link' => '/page_dashboard',
                'allowed_roles' => ['1'],
                'parent_title' => null,
                'menu_order' => '0',
            ],
            [
                'title' => 'Users',
                'icon' => 'users',
                'link' => '/page_usermanagement',
                'allowed_roles' => ['1'],
                'parent_title' => null,
                'menu_order' => '6',
            ],
            [
                'title' => 'Team Management',
                'icon' => 'briefcase',
                'link' => '/page_team_management',
                'allowed_roles' => ['1'],
                'parent_title' => null,
                'menu_order' => '7',
            ],
            [
                'title' => 'Developer Option',
                'icon' => 'shield-check',
                'link' => '#',
                'allowed_roles' => ['1'],
                'parent_title' => null,
                'menu_order' => '8',
            ],

            // --- children: each parent above must be seeded first ---
            [
                'title' => 'Mailer',
                'icon' => 'envelope',
                'link' => '/page_mailer',
                'allowed_roles' => ['1'],
                'parent_title' => 'Developer Option',
                'menu_order' => '1',
            ],
            [
                'title' => 'Menus',
                'icon' => 'bars-3',
                'link' => '/page_menus',
                'allowed_roles' => ['1'],
                'parent_title' => 'Developer Option',
                'menu_order' => '2',
            ],
        ];

        foreach ($menu_array as $menu) {
            $parentId = '0';

            if ($menu['parent_title']) {
                $parent = NavMenu::where('title', $menu['parent_title'])->first();

                if (! $parent) {
                    throw new RuntimeException(
                        "NavMenuSeeder: parent '{$menu['parent_title']}' for '{$menu['title']}' must be listed (and seeded) before it."
                    );
                }

                $parentId = (string) $parent->id;
            }

            NavMenu::updateOrCreate(
                ['title' => $menu['title']],
                [
                    'icon' => $menu['icon'],
                    'link' => $menu['link'],
                    'allowed_roles' => json_encode($menu['allowed_roles']),
                    'parent_menu' => $parentId,
                    'menu_order' => $menu['menu_order'],
                ]
            );
        }
    }
}
