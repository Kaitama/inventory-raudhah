<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use App\Models\Kasi;
use App\Models\Inventory;

class InventoryExport implements FromCollection, ShouldAutoSize, WithHeadings, WithCustomStartCell, WithTitle, WithMapping
{
	protected $kasi_id, $no = 0;
	
	public function __construct($kasi_id)
	{
		$this->kasi_id = $kasi_id;
	}
	
	public function collection()
	{
		$i = Inventory::where('kasi_id', $this->kasi_id)->get();
		return $i;
	}
	
	public function map($i): array
	{
		return [
			++$this->no,
			$i->kasi->section['name'],
			$i->kasi['name'],
			$this->formatDateId($i->obtained_at),
			$i->name,
			$i->details->count(),
			$i->unit,
			$i->price,
			$i->details->count() * $i->price,
			$i->from,
			$i->label,
			$i->description,
			$i->details->where('condition', 1)->count(),
			$i->details->where('condition', 2)->count(),
			$i->details->where('condition', 3)->count(),
		];
	}

	public function title(): string { return 'DATA INVENTARIS'; } 

	public function startCell(): string { return 'A1'; }

	public function headings(): array 
	{
		return [
			'NO.',
			'BIDANG',
			'KASI',
			'TANGGAL PEROLEHAN',
			'NAMA INVENTARIS',
			'JUMLAH',
			'UNIT',
			'HARGA SATUAN',
			'TOTAL HARGA',
			'ASAL',
			'LABEL',
			'KETERANGAN',
			'BAIK',
			'RUSAK',
			'HILANG'
		];
	}
	
	private function formatDateId($datetime)
	{
		try {
			$date = date('Y-m-d', strtotime($datetime));
			$d = explode('-', $date);
			$dt = $d[2] . '/' . $d[1] . '/' . $d[0];
			return $dt;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}
}