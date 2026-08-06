<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Support\RoleHelper;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function ($user) {
            return RoleHelper::roleName($user) === 'superadmin';
        });

        // Recruitment "App Settings" maintenance area (form builder, lookup
        // lists, checklist groups) — matches the roles the App Settings nav
        // item is configured to allow (nav_menus.allowed_roles).
        Gate::define('manageAppSettings', function ($user) {
            return in_array(RoleHelper::roleName($user), ['superadmin', 'admin', 'developer'], true);
        });
    }
}
