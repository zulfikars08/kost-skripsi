<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Transaksi;
use Carbon\Carbon;

class TransaksiExport implements FromView, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function view(): View
    {
        // Query the data you need and map it to the desired format
        $transaksiData = Transaksi::all()->map(function ($item) {
            return [
                $item->id,
                $item->kamar ? $item->kamar->no_kamar : '-',
                $item->penyewa ? $item->penyewa->nama : '-',
                $item->lokasiKos ? $item->lokasiKos->nama_kos : '-',
                $item->tanggal ?? '-',
                $item->jumlah_tarif,
                $item->tipe_pembayaran ?: '-',
                $item->tipe_pembayaran === 'non-tunai' && $item->bukti_pembayaran
                    ? asset('storage/' . $item->bukti_pembayaran)
                    : ($item->tipe_pembayaran === 'tunai' ? 'Cash Payment' : 'No Bukti Pembayaran'),
                $item->status_pembayaran,
                $item->tanggal_pembayaran_awal ?: '-',
                $item->tanggal_pembayaran_akhir ?: '-',
                $item->kebersihan,
                ($item->jumlah_tarif === 0 && $item->kebersihan === 0) ? 0 : ($item->jumlah_tarif - $item->kebersihan),
                $item->pengeluaran,
                $item->keterangan,
            ];
        });

        return view('pdf.template', compact('transaksiData'));
    }

    public function headings(): array
    {
        return [
            'No',
            'No Kamar',
            'Nama',
            'Nama Kos',
            'Tanggal',
            'Jumlah Tarif',
            'Tipe Pembayaran',
            'Bukti Pembayaran',
            'Status Pembayaran',
            'Tanggal Awal',
            'Tanggal Akhir',
            'Kebersihan',
            'Total',
            'Pengeluaran',
            'Keterangan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:O1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
