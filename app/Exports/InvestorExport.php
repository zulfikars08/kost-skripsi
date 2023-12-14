<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as StyleBorder;
use App\Models\Investor; // Adjust the namespace based on your Investor model
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InvestorExport implements FromCollection, WithHeadings, WithStyles
{
    protected $investors;

    public function __construct($investors)
    {
        $this->investors = $investors;
    }
    protected $casts = [
        'pemasukan' => 'float', // or 'integer', depending on your context
        'pengeluaran' => 'float', // or 'integer'
        // ... other casts ...
    ];
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
                'Rp' . number_format($lastPendapatanBersih, 0, ',', '.'),
                'Rp' . number_format($totalPendapatan, 0, ',', '.'),
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
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFCCCCCC'],
            ],
        ]);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:I' . $highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => StyleBorder::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Apply currency format to the 'Pendapatan Bersih' and 'Total Pendapatan' columns
        $currencyFormat = '"Rp"#,##0;-Rp#,##0';
        $sheet->getStyle('H2:H' . $highestRow)->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle('I2:I' . $highestRow)->getNumberFormat()->setFormatCode($currencyFormat);

        // Set specific column widths
        $sheet->getColumnDimension('A')->setWidth(5); // Example width, adjust as needed
        $sheet->getColumnDimension('B')->setWidth(15); // Example width, adjust as needed
        // Continue for other columns as necessary

        // Optionally, set the row height for all rows
        for ($i = 1; $i <= $highestRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(15); // Example height, adjust as needed
        }
    }
}


