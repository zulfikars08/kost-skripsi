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
        // Transform your $this->data into a collection
        $data = $this->laporanKeuangan->map(function ($item) {
            return [
                $item->tanggal,
                $item->kamar->no_kamar,
                $item->lokasi->nama_kos,
                $item->jenis,
                $item->keterangan,
                $item->pemasukan,
                $item->pengeluaran,
            ];
        });

        // Calculate the total pemasukan, total pengeluaran, and total pendapatan
        $totalPemasukan = $data->sum(function ($row) {
            return $row[5]; // Column index of Jumlah Pemasukan
        });

        $totalPengeluaran = $data->sum(function ($row) {
            return $row[6]; // Column index of Jumlah Pengeluaran
        });

        $totalPendapatan = $totalPemasukan - $totalPengeluaran;

        // Add totals to the data
        $data->push(['', '', '', '', '', $totalPemasukan, $totalPengeluaran]);
        $data->push(['', '', '', '', '', 'Total Pendapatan:', $totalPendapatan]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Kamar',
            'Nama Kos',
            'Jenis',
            'Keterangan',
            'Jumlah Pemasukan',
            'Jumlah Pengeluaran',
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

