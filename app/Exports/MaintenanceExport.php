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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

use App\Models\Maintenance;

class MaintenanceExport implements FromCollection, ShouldAutoSize, WithHeadings, WithCustomStartCell, WithTitle, WithMapping, WithEvents, WithColumnFormatting
{
	use RegistersEventListeners;
	protected $from, $to, $no = 0;
	
	public function __construct($from, $to)
	{
		$this->from = Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d');
		$this->to = Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d');
	} 
	
	public function collection()
	{
		$m = Maintenance::whereDate('maintained_at', '>=', $this->from)->whereDate('maintained_at', '<=', $this->to)->get();
		return $m;
	}
	
	public function map($m): array
	{
		
		return [
			++$this->no,
			$m->invdetail->inventory->kasi->section['name'],
			$m->invdetail->inventory->kasi['name'],
			$m->invdetail['barcode'],
			$m->invdetail->inventory['name'],
			$this->formatDateId($m->maintained_at),
			$m->name,
			$m->description,
			$m->price
		];
	}
	
	public function title(): string { return 'LAPORAN MAINTENANCE'; } 
	
	public function startCell(): string { return 'A1'; }
	
	public function headings(): array 
	{
		return [
			'NO.',
			'BIDANG',
			'KASI',
			'BARCODE',
			'NAMA INVENTARIS',
			'TANGGAL',
			'MAINTENANCE',
			'KETERANGAN',
			'BIAYA'
		];
	}

	public function columnFormats(): array
	{
		return [
			'D' => '#',
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