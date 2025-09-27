<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Permissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermission($permission->name);
            });
        }
    }
    private function getPermissions()
    {
        if (Schema::hasTable('permissions')) {
            // Get all permissions. In production, consider caching this result.
            return Permission::all();
        } else {
            return collect(); // Return empty collection if the table does not exist
        }
    }
}
