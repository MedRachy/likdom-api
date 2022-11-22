<?php

namespace App\Providers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // check if the user is the owner of a reservation 
        Gate::define('access-sub', function (User $user, Subscription $subscription) {
            return $user->id === $subscription->user_id;
        });
        //
    }
}
