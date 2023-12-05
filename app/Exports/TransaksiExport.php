<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class TransaksiExport implements FromCollection, WithHeadings, WithStyles
{
    protected $filteredTransaksiData;

    public function __construct($filteredTransaksiData)
    {
        $this->filteredTransaksiData = $filteredTransaksiData;
    }

    public function collection()
    {
        $collection = new Collection();

        foreach ($this->filteredTransaksiData as $item) {
            // Prepare the data to be added to the collection
            $collection->push([
                'No' => $item->id,
                'No Kamar' => $item->kamar->no_kamar ?? '-',
                'Nama' => $item->penyewa->nama ?? 'No Penyewa',
                'Lokasi Kos' => $item->lokasiKos->nama_kos ?? '-',
                'Tanggal' => $item->tanggal ?? '-',
                'Jumlah Tarif' => $item->jumlah_tarif ?? 0,
                'Tipe Pembayaran' => $item->tipe_pembayaran ?? '-',
                'Bukti Pembayaran' => $item->bukti_pembayaran ? 'Available' : 'Not Available', // Adjust as needed
                'Status Pembayaran' => $item->status_pembayaran ?? '-',
                // ... Add other fields as necessary
            ]);
        }

        return $collection;
    }

    public function headings(): array
    {
        return [
            'No',
            'No Kamar',
            'Nama',
            'Lokasi Kos',
            'Tanggal',
            'Jumlah Tarif',
            'Tipe Pembayaran',
            'Bukti Pembayaran',
            'Status Pembayaran',
            // ... Add other headings as necessary
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the headings row
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            // ... Add styles for other rows as needed
        ];
    }
}
