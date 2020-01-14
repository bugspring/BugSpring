<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

use Bouncer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // put every user into the role 'user'
        User::observe(UserObserver::class);

        // allow everyone in the role 'user' to own projects
        Bouncer::ownedVia(Project::class, 'owner_id');
    }
}
