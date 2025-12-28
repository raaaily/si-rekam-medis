<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            // listener kosong, pakai closure
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        \Event::listen(Login::class, function ($event) {
            $event->user->update([
                'last_login_at' => now(),
            ]);
        });
    }
}
