<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        $nomor = 1;
        $data = $this->laporanKeuangan->map(function ($item) use (&$nomor) {
            return [
                $nomor++,
                $item->kode_laporan,
                $item->kode_pemasukan,
                $item->kode_pengeluaran,
                $item->tanggal,
                optional($item->kamar)->no_kamar ?? '-',
                optional($item->lokasiKos)->nama_kos ?? '-',
                $item->tipe_pembayaran ?: '-',
                $item->jenis,
                $item->bukti_pembayaran ?: '-',
                $item->tanggal_pembayaran_awal ?: '-',
                $item->tanggal_pembayaran_akhir ?: '-',
                $item->status_pembayaran,
                $item->jenis === 'pemasukan' ? $item->pemasukan : 0,
                $item->jenis === 'pengeluaran' ? $item->pengeluaran : 0,
                $item->keterangan,
            ];
        });

        $totalPemasukan = $data->sum(function ($row) {
            return $row[13]; // Assuming 'pemasukan' is at index 13
        });

        $totalPengeluaran = $data->sum(function ($row) {
            return $row[14]; // Assuming 'pengeluaran' is at index 14
        });

        $totalPendapatan = $totalPemasukan - $totalPengeluaran;

        $data->push(['', '', '', '', '', '', '', '', '', '', '', '', 'Total Pemasukan', $totalPemasukan, '']);
        $data->push(['', '', '', '', '', '', '', '', '', '', '', '', 'Total Pengeluaran', '', $totalPengeluaran]);
        $data->push(['', '', '', '', '', '', '', '', '', '', '', '', 'Pendapatan Bersih', '', $totalPendapatan]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Laporan',
            'Kode Pemasukan',
            'Kode Pengeluaran',
            'Tanggal',
            'No Kamar',
            'Lokasi Kos',
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
        // Apply styles to header
        $sheet->getStyle('A1:P1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FFCCCCCC'],
            ],
        ]);

        // Apply styles to cells
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:P' . $highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Apply currency format to the 'Jumlah Pemasukan' and 'Jumlah Pengeluaran' columns
        $currencyFormat = 'Rp#,##0;-Rp#,##0';
        $sheet->getStyle('N2:N' . $highestRow)->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle('O2:O' . $highestRow)->getNumberFormat()->setFormatCode($currencyFormat);

        // Style for the total rows
        $sheet->getStyle('M' . ($highestRow - 2) . ':P' . $highestRow)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ],
        ]);

        // Set auto column width
        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setWidth(12);
        }
        // Set the row height for the header row
        $sheet->getRowDimension(1)->setRowHeight(20);

        return $sheet;
    }
}
