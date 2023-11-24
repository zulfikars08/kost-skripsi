<?php

namespace App\Listeners;

use App\Models\LaporanKeuangan;
use App\Models\TanggalInvestor;
use App\Models\TanggalLaporan;
use App\Events\PemasukanCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateLaporanKeuangan
{
    use InteractsWithQueue;
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
     * @param  \App\Providers\PemasukanCreated  $event
     * @return void
     */
    public function handle(PemasukanCreated $event)
    {
        $pemasukan = $event->pemasukan;

        // Extract necessary data
        $tanggal = $pemasukan->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $nama_kos = $pemasukan->lokasiKos->nama_kos;

        // Prepare attributes for LaporanKeuangan
        $laporanKeuanganAttributes = [
            'tanggal' => $tanggal,
            'kamar_id' => $pemasukan->kamar_id,
            'lokasi_id' => $pemasukan->lokasi_id,
            'pemasukan_id' => $pemasukan->id,
            'jenis' => 'pemasukan',
            'nama_kos' => $nama_kos,
            'kode_pemasukan' => $pemasukan->kode_pemasukan,
            'tipe_pembayaran' => $pemasukan->tipe_pembayaran,
            'bukti_pembayaran' => $pemasukan->bukti_pembayaran,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pemasukan' => $pemasukan->jumlah,
            'keterangan' => $pemasukan->keterangan,
        ];

        // Prepare attributes for TanggalLaporan
        $tanggalLaporanAtributes = [
            'nama_kos' => $nama_kos,
            'kamar_id' => $pemasukan->kamar_id,
            'lokasi_id' => $pemasukan->lokasi_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal' => $pemasukan->tanggal,
        ];

        // Prepare attributes for TanggalInvestor
        $tanggalInvestorAttributes = [
            'nama_kos' => $nama_kos,
            'lokasi_id' => $pemasukan->lokasi_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal' => $pemasukan->tanggal,
        ];

        // Create a new LaporanKeuangan instance
        $laporanKeuangan = new LaporanKeuangan($laporanKeuanganAttributes);

        // Check if TanggalLaporan entry already exists
        $existingLaporan = TanggalLaporan::where('nama_kos', $nama_kos)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        // Check if TanggalInvestor entry already exists
        $existingInvestor = TanggalInvestor::where('nama_kos', $nama_kos)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        // Update or create TanggalLaporan entry
        if ($existingLaporan) {
            $existingLaporan->update($tanggalLaporanAtributes);
        } else {
            $tanggalLaporan = new TanggalLaporan($tanggalLaporanAtributes);
            $tanggalLaporan->save();
        }

        // Update or create TanggalInvestor entry
        if ($existingInvestor) {
            $existingInvestor->update($tanggalInvestorAttributes);
        } else {
            $tanggalInvestor = new TanggalInvestor($tanggalInvestorAttributes);
            $tanggalInvestor->save();
        }

        // Save the new LaporanKeuangan instance
        $laporanKeuangan->save();
    }
}
