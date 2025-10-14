<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendWelcomeEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendWelcomeEmail::class, // The listener for the Registered event
        ],
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // You can register any services, bindings, or classes here
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // This method is used to bootstrap services, events, etc.
        // Laravel will automatically register events and listeners defined in the `$listen` property.
    }
}
