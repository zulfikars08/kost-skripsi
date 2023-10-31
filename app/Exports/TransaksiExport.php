<?php

// Unfiltered Transaction Export
// app/Exports/TransaksiExport.php

// app/Exports/TransaksiExport.php

// app/Exports/TransaksiExport.php



namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Border as StyleBorder;

class TransaksiExport implements FromCollection, WithHeadings, WithStyles
{
    protected $filteredTransaksiData;
    protected $namaKos;
    protected $namaBulan;

    public function __construct($filteredTransaksiData, $namaKos, $namaBulan)
    {
        $this->filteredTransaksiData = $filteredTransaksiData;
        $this->namaKos = $namaKos;
        $this->namaBulan = $namaBulan;
    }

    public function collection()
    {
        // Transform your $this->data into a collection
        $collection = new Collection();

        $nomor = 1;
        foreach ($this->filteredTransaksiData as $item) {
            $collection->push([
                'No' =>  $nomor++,
                'No Kamar' => $item->kamar ? $item->kamar->no_kamar : '-',
                'Nama' => $item->penyewa ? $item->penyewa->nama : '-',
                'Nama Kos' => $item->lokasiKos ? $item->lokasiKos->nama_kos : '-',
                'Tanggal' => $item->tanggal ?? '-',
                'Jumlah Tarif' => $item->jumlah_tarif,
                'Tipe Pembayaran' => $item->tipe_pembayaran ? $item->tipe_pembayaran : '-',
                'Bukti Pembayaran' => $item->tipe_pembayaran === 'non-tunai' && $item->bukti_pembayaran
                ? asset('storage/' . $item->bukti_pembayaran)
                : ($item->tipe_pembayaran === 'tunai' ? 'Cash Payment' : 'No Bukti Pembayaran'),
                'Tanggal Awal Pembayaran' => $item->tanggal_pembayaran_awal ?? '-',
                'Tanggal Akhir Pembayaran' => $item->tanggal_pembayaran_akhir ?? '-',
                'Kebersihan' => $item->kebersihan,
                'Total' => ($item->jumlah_tarif === 0 && $item->kebersihan === 0) ? 0 : ($item->jumlah_tarif - $item->kebersihan),
                'Pengeluaran' => $item->pengeluaran,
                'Keterangan' => $item->keterangan,
                'Status Pembayaran' => $item->status_pembayaran,
                // Tambahkan kolom lainnya sesuai kebutuhan Anda
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
            'Nama Kos',
            'Tanggal',
            'Jumlah Tarif',
            'Tipe Pembayaran',
            'Bukti Pembayaran',
            'Tanggal Awal Pembayaran',
            'Tanggal Akhir Pembayaran',
            'Kebersihan',
            'Total',
            'Pengeluaran',
            'Keterangan',
            'Status Pembayaran',
            // Tambahkan kolom lainnya sesuai kebutuhan Anda
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->filteredTransaksiData);
        $cellRange = 'A2:O' . ($rowCount + 1);

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], // Rata kiri
            ],
            $cellRange => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], // Rata kiri
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => StyleBorder::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
