<?php

namespace App\Providers;

use App\Providers\PenyewaCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTransaksi
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
     * @param  \App\Providers\PenyewaCreated  $event
     * @return void
     */
    public function handle(PenyewaCreated $event)
    {
        //
    }
}
