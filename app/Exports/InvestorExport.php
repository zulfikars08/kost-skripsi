<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as StyleBorder;
use App\Models\Investor; // Adjust the namespace based on your Investor model

class InvestorExport implements FromCollection, WithHeadings, WithStyles
{
    protected $investors;

    public function __construct($investors)
    {
        $this->investors = $investors;
    }

    public function collection()
    {
        // Transform your $this->investors into a collection
        $data = $this->investors->map(function ($investor, $key) {
            // Calculate Pendapatan Bersih and Total Pendapatan
            $lastLaporanKeuangan = optional($investor->lastLaporanKeuangan);
            $jumlahPintu = $investor->jumlah_pintu;
            $lokasiKos = $investor->lokasiKos;
            $totalKamar = optional($lokasiKos)->jumlah_kamar ?? 0;
    
            // Calculate Pendapatan Bersih and Total Pendapatan using the provided logic
            $lastPendapatanBersih = \App\Models\LaporanKeuangan::where('nama_kos', $investor->nama_kos)
                ->where('bulan', $investor->bulan)
                ->where('tahun', $investor->tahun)
                ->orderBy('id', 'desc')
                ->value('pendapatan_bersih');
    
            $totalPendapatan = ($lastLaporanKeuangan) ? ($jumlahPintu / max(1, $totalKamar)) * $lastPendapatanBersih : 0;

            // Add more fields as needed
            return [
                'No' => $key + 1,
                'Nama' => $investor->nama,
                'Bulan' => $investor->bulan,
                'Tahun' => $investor->tahun,
                'Jumlah Pintu' => $jumlahPintu,
                'Lokasi' => $investor->lokasiKos->nama_kos,
                'Total Kamar' => $totalKamar,
                'Pendapatan Bersih' =>  $lastPendapatanBersih,
                'Total Pendapatan' => $totalPendapatan,
            ];
        });

        return $data;
    }

    public function headings(): array
    {
        return [
            'No', 'Nama', 'Bulan', 'Tahun', 'Jumlah Pintu', 'Lokasi', 'Total Kamar', 'Pendapatan Bersih', 'Total Pendapatan'
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


