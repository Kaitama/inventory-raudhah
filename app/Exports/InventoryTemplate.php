<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use App\Models\Kasi;

class InventoryTemplate implements WithMultipleSheets
{
	use Exportable;
	
	public function sheets(): array
	{
		$sheets = [];
		$sheets[] = new InventoryTemplateExport();
		$sheets[] = new DataKasi();
		return $sheets;
	}
	
}

class InventoryTemplateExport implements ShouldAutoSize, WithStyles, WithHeadings, WithCustomStartCell, WithTitle, WithEvents, WithColumnFormatting
{
	use RegistersEventListeners;
	
	public function styles(Worksheet $sheet) { 
		return [
			1 => ['font' => ['bold' => true, 'size' => 14]], 
			2 => ['font' => ['bold' => true, 'size' => 14]],
			'A1:L1' => ['alignment' => [
				// 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],],
			'D1:F1' => ['alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],],
		]; 
	}
	
	public function collection(){ return collect(); }
	
	public function startCell(): string { return 'A1'; }
	
	public function title(): string { return 'DATA INVENTARIS'; } 
	
	public function headings(): array
	{
		return [[
			'NO.',
			'ID KASI',
			'NAMA INVENTARIS',
			'DIPEROLEH PADA',
			'',
			'',
			'JUMLAH',
			'UNIT',
			'HARGA SATUAN',
			'ASAL',
			'LABEL',
			'KETERANGAN',
		], [
			'', '', '', 'TANGGAL', 'BULAN', 'TAHUN'
			]
		];
	}
	
	public static function afterSheet(AfterSheet $event)
	{
		
		$sheet = $event->sheet->getDelegate();
		$sheet->getComment('B1')->getText()->createTextRun('Hanya isi ID KASI (dapat dilihat pada sheet DATA KASI).');
		$sheet->getComment('D2')->getText()->createTextRun('Hanya isi angka tanggal.');
		$sheet->getComment('E2')->getText()->createTextRun('Hanya isi angka bulan.');
		$sheet->getComment('F2')->getText()->createTextRun('Hanya isi angka tahun.');
		$sheet->getComment('G1')->getText()->createTextRun('Hanya diisi angka.');
		$sheet->getComment('H1')->getText()->createTextRun('Buah, Box, Bungkus, dll.');
		$sheet->getComment('I1')->getText()->createTextRun('Hanya diisi angka, tanpa simbol Rp atau titik.');
		
		$sheet->getStyle('B1:D1')->getFont()->getColor()->setRGB('ff0000');
		$sheet->getStyle('D2:F2')->getFont()->getColor()->setRGB('ff0000');
		$sheet->getStyle('A1:L2')->getBorders()->getAllBorders()
		->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
		// $sheet->getRowDimension('1')->setRowHeight(36);

		$sheet->mergeCells('A1:A2');
		$sheet->mergeCells('B1:B2');
		$sheet->mergeCells('C1:C2');
		$sheet->mergeCells('D1:F1');
		$sheet->mergeCells('G1:G2');
		$sheet->mergeCells('H1:H2');
		$sheet->mergeCells('I1:I2');
		$sheet->mergeCells('J1:J2');
		$sheet->mergeCells('K1:K2');
		$sheet->mergeCells('L1:L2');
	}
	
	public function columnFormats(): array
	{
		return [
			// 'J' => NumberFormat::FORMAT_TEXT,
			// 'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
		];
	}
}

class DataKasi implements FromCollection, WithTitle, WithStyles, WithHeadings, ShouldAutoSize, WithCustomStartCell
{
	public function collection()
	{
		//
		$kasis = Kasi::all();
		foreach ($kasis as $kasi) {
			unset($kasi['section_id']);
			unset($kasi['description']);
			unset($kasi['created_at']);
			unset($kasi['updated_at']);
		}
		return $kasis->sortBy('id');
	}
	public function startCell(): string { return 'A1'; }
	
	public function headings(): array { return ['ID KASI', 'NAMA KASI'];	}
	
	public function title(): string { return 'DATA KASI'; }
	
	public function styles(Worksheet $sheet) { return [1 => ['font' => ['bold' => true, 'size' => 16]]]; }
}