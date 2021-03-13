<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Livewire\Dashboard\Index as DashboardIndex;
use App\Http\Livewire\Maintenance\Index as MaintenanceIndex;
use App\Http\Livewire\Section\Index as SectionIndex;
use App\Http\Livewire\Kasi\Index as KasiIndex;
use App\Http\Livewire\Inventory\Index as InventoryIndex;
use App\Http\Livewire\Inventory\Show as InventoryShow;
use App\Http\Livewire\Frontpage\Inventoryview as InventoryView;
use App\Http\Livewire\User\Index as UserIndex;
use App\Http\Livewire\User\Setting as UserSetting;
use App\Exports\InventoryTemplate;
use App\Imports\InventoryImport;
use App\Exports\InventoryExport;
use App\Exports\MaintenanceExport;
use App\Models\Inventory;


Route::get('/', function () {
	// return view('welcome');
	return redirect('login');
});


Route::get('/inventaris/{barcode}', InventoryView::class)->name('inventoryview');

Route::middleware('auth')->prefix('dashboard')->group(function(){
	Route::get('/', DashboardIndex::class)->name('dashboard.index');
	
	// maintenances
	Route::get('/maintenances', MaintenanceIndex::class)->name('maintenances.index');
	Route::post('/maintenances/export', function(Request $request){
		return Excel::download(new MaintenanceExport($request->from, $request->to), 'LAPORAN_MAINTENANCE_' . time() . '.xlsx');
	})->name('maintenances.export');
	
	// sections
	Route::get('/sections', SectionIndex::class)->name('sections.index');
	
	// kasis
	Route::get('/kasis', KasiIndex::class)->name('kasis.index');
	
	// inventories
	Route::get('/inventories', InventoryIndex::class)->name('inventories.index');
	Route::get('/inventories/{inventory}', InventoryShow::class)->name('inventories.show');
	Route::get('/inventories/export/template', function(){
		return Excel::download(new InventoryTemplate, 'TEMPLATE_INVENTARIS_' . time() . '.xlsx');
	})->name('inventories.template');
	Route::post('/inventories/import', function(Request $request){
		Excel::import(new InventoryImport, $request->file('inventories'));
		return back()->with('success', 'Data inventaris berhasil diupload.');
	})->name('inventories.import');
	Route::post('/inventories/export', function(Request $request){
		return Excel::download(new InventoryExport($request->kasi_id), 'LAPORAN_INVENTARIS_' . time() . '.xlsx');
	})->name('inventories.export');
	Route::get('/inventories/qrcode/{inventory}', function(Inventory $inventory){
		$pdf = PDF::loadView('inventorypdf', ['inventory' => $inventory]);
		return $pdf->stream('qrcode.pdf');
	})->name('inventories.qrcode');

	// users
	Route::get('/users', UserIndex::class)->name('users.index');
	Route::get('/users/setting', UserSetting::class)->name('users.setting');
});