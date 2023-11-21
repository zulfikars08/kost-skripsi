<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as StyleBorder;

class LaporanKeuanganExport implements FromCollection, WithHeadings, WithStyles
{
    protected $laporanKeuangan;
    protected $namaKos;
    protected $namaBulan;

    public function __construct($laporanKeuangan, $namaKos, $namaBulan)
    {
        $this->laporanKeuangan = $laporanKeuangan;
        $this->namaKos = $namaKos;
        $this->namaBulan = $namaBulan;
    }
    public function collection()
    {
        // Transform your $this->laporanKeuangan into a collection
        $data = $this->laporanKeuangan->map(function ($item) {
            return [
                $item->id,
                $item->kode_laporan,
                $item->kode_pemasukan,
                $item->kode_pengeluaran,
                $item->tanggal,
                $item->kamar->no_kamar,
                $item->lokasiKos->nama_kos,
                $item->tipe_pembayaran ? $item->tipe_pembayaran : '-',
                $item->jenis,
                $item->bukti_pembayaran ? $item->bukti_pembayaran : '-',
                $item->tanggal_pembayaran_awal ? $item->tanggal_pembayaran_awal : '-',
                $item->tanggal_pembayaran_akhir ? $item->tanggal_pembayaran_akhir : '-',
                $item->status_pembayaran,
                $item->jenis === 'pemasukan' ? $item->pemasukan : 0,
                $item->jenis === 'pengeluaran' ? $item->pengeluaran : 0,
                $item->keterangan,
            ];
        });

        // Calculate the total pemasukan, total pengeluaran, and total pendapatan
        $totalPemasukan = $data->sum(function ($row) {
            return $row[13]; // Column index of Jumlah Pemasukan
        });

        $totalPengeluaran = $data->sum(function ($row) {
            return $row[14]; // Column index of Jumlah Pengeluaran
        });

        $totalPendapatan = $totalPemasukan - $totalPengeluaran;

        // Add totals to the data
        $data->push(['', '', '', '', '', '', '', '', '', '', '', '', 'Total Pemasukan:', $totalPemasukan, '']);
        $data->push(['', '', '', '', '', '', '', '', '', '', '', '', 'Total Pengeluaran:', '', $totalPengeluaran]);
        $data->push(['', '', '', '', '', '', '', '', '', '', '', '', 'Pendapatan Bersih:', '', $totalPendapatan]);

        return $data;
    }

    public function headings(): array
    {
        // Adjust the column headings as needed
        return [
            'No',
            'Kode Laporan',
            'Kode Pemasukan',
            'Kode Pengeluaran',
            'Tanggal',
            'No Kamar',
            'Nama Kos',
            'Tipe Pembayaran',
            'Jenis',
            'Bukti Pembayaran',
            'Tanggal Pembayaran Awal',
            'Tanggal Pembayaran Akhir',
            'Status Pembayaran',
            'Jumlah Pemasukan',
            'Jumlah Pengeluaran',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set the entire worksheet to have a border and left alignment
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => StyleBorder::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
        ]);
    }
}

