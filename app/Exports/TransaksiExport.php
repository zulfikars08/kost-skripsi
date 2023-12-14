<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
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
            $nomor = 1;
            $collection->push([
                $nomor++,
                'No Kamar' => $item->kamar->no_kamar ?? '-',
                'Nama' => $item->penyewa->nama ?? 'No Penyewa',
                'Lokasi Kos' => $item->lokasiKos->nama_kos ?? '-',
                'Rp' . number_format($item->kamar->harga, 0, ',', '.') ,
                'Tanggal' => $item->tanggal ?? '-',
                'Rp' . number_format($item->jumlah_tarif, 0, ',', '.') ,
                'Tipe Pembayaran' => $item->tipe_pembayaran ?? '-',
                'Bukti Pembayaran' => $item->bukti_pembayaran ? 'Available' : 'Not Available',
                'Status Pembayaran' => $item->status_pembayaran ?? '-',
                'Tanggal Awal' => $item->tanggal_awal ?? '-',
                'Tanggal Akhir' => $item->tanggal_akhir ?? '-',
                'Keterangan' => $item->keterangan ?? '-'
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
            'Tarif Kamar',
            'Tanggal',
            'Jumlah Tarif',
            'Tipe Pembayaran',
            'Bukti Pembayaran',
            'Status Pembayaran',
            'Tanggal Awal',
            'Tanggal Akhir',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:L1')->applyFromArray([
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

        // Assuming 'Jumlah Tarif' is in column 'F'
        $highestRow = $sheet->getHighestRow();
        if ($highestRow >= 1) { // Ensure there's at least the header row
            // Apply currency format to 'Jumlah Tarif' column
            $sheet->getStyle('F2:F' . $highestRow)->getNumberFormat()->setFormatCode('"Rp" #,##0');
            // Apply text wrap and vertical centering to all cells
            // $sheet->getStyle('A2:L' . $highestRow)->getAlignment()->setWrapText(true);
            // $sheet->getStyle('A2:L' . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Set borders for all the cells in the range
        $sheet->getStyle('A1:L' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Optionally, set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(15);
        // ... Set other column widths as necessary

        // Optionally, set row height
        $sheet->getRowDimension(1)->setRowHeight(20);
        // ... Set other row heights as necessary
    }
}
