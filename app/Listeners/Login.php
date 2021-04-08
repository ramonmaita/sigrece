<?php

namespace App\Listeners;

use App\Events\LoginExitoso;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Login
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoginExitoso  $event
     * @return void
     */
    public function handle(LoginExitoso $event)
    {
        //
    }
}
