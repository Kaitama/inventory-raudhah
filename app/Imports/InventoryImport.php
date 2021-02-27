<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Models\Inventory;
use App\Models\Invdetail;

class InventoryImport implements WithMultipleSheets
{
	
	public function sheets(): array
	{
		return [
			0 => new InventoryData(),
		];
	}
}

class InventoryData implements ToModel, WithStartRow
{
	public function model(array $row)
	{
		$inventory = Inventory::create([
			'kasi_id'	=> $row[1],
			'name'	=> $row[2],
			'obtained_at' => $row[5] . '-' . $row[4] . '-' . $row[3],
			'unit'	=> $row[7],
			'price'	=> $row[8],
			'from'	=> $row[9],
			'label'	=> $row[10],
			'description'	=> $row[11],
			]
		);
		$a = str_replace('-', '', $inventory->obtained_at->toDateString());
		$b = Invdetail::withTrashed()->where('barcode', 'like', $a . '%')->get()->max();
		if($b) $bc = substr($b->barcode, -4);
		for ($i=1; $i <= $row[6]; $i++) { 
			Invdetail::create([
				'inventory_id'	=> $inventory->id,
				'barcode'	=> $b ? $this->barcoding($a, $bc, $i) : $a . str_pad($i, 4, '0', STR_PAD_LEFT),
				]
			);
		}
		return $inventory;
	}
	
	private function barcoding($base, $newval, $increment)
	{
	    $add = $newval + $increment;
	    return $base . str_pad($add, 4, '0', STR_PAD_LEFT);
	}

	public function startRow(): int
	{
		return 3;
	}
	

}