<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LaporanExport implements FromArray, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $laporanData;
    protected $totalPenjualan;
    protected $totalPembelian;
    protected $selisih;

    public function __construct(array $laporanData, $totalPenjualan, $totalPembelian, $selisih)
    {
        $this->laporanData = $laporanData;
        $this->totalPenjualan = $totalPenjualan;
        $this->totalPembelian = $totalPembelian;
        $this->selisih = $selisih;
    }

    public function array(): array
    {
        return $this->laporanData;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Deskripsi',
            'Nominal',
            'Tanggal',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row['kategori'],
            $row['deskripsi'],
            'Rp ' . number_format($row['nominal'], 0, ',', '.'),
            $row['tanggal'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Data rows styling
        $lastRow = count($this->laporanData) + 1;
        $sheet->getStyle('A2:E' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Center align untuk kolom No
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Right align untuk kolom Nominal
        $sheet->getStyle('D2:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Summary section (di bawah tabel)
        $summaryRow = $lastRow + 2;
        $sheet->setCellValue('A' . $summaryRow, 'RINGKASAN');
        $sheet->mergeCells('A' . $summaryRow . ':E' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB'],
            ],
        ]);

        // Total Penjualan
        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Penjualan');
        $sheet->setCellValue('D' . $summaryRow, 'Rp ' . number_format($this->totalPenjualan, 0, ',', '.'));
        $sheet->mergeCells('A' . $summaryRow . ':C' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);
        $sheet->getStyle('D' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '10B981']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        // Total Pembelian
        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Pembelian');
        $sheet->setCellValue('D' . $summaryRow, 'Rp ' . number_format($this->totalPembelian, 0, ',', '.'));
        $sheet->mergeCells('A' . $summaryRow . ':C' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);
        $sheet->getStyle('D' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'EF4444']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        // Selisih
        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Selisih (Penjualan - Pembelian)');
        $sheet->setCellValue('D' . $summaryRow, ($this->selisih >= 0 ? '+' : '') . ' Rp ' . number_format($this->selisih, 0, ',', '.'));
        $sheet->mergeCells('A' . $summaryRow . ':C' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);
        $sheet->getStyle('D' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => $this->selisih >= 0 ? '10B981' : 'EF4444']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 15,
            'C' => 45,
            'D' => 20,
            'E' => 15,
        ];
    }

    public function title(): string
    {
        return 'Laporan Keuangan';
    }
}
