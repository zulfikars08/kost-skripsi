<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PenyewaCreated;
use App\Models\Transaksi;
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
     * @param  object  $event
     * @return void
     */
    public function handle(PenyewaCreated $event)
    {
        //
        $penyewa = $event->penyewa;

        // Lakukan logika untuk membuat data transaksi sesuai dengan data penyewa
        Transaksi::create([
            'penyewa_id' => $penyewa->id,
            'lokasi_id' => $penyewa->lokasi_id,
            'kebersihan' => 0, // Isi dengan nilai default
            'pengeluaran' => 0, // Isi dengan nilai default
            // Isi dengan kolom-kolom lain sesuai kebutuhan
        ]);
    }
}
