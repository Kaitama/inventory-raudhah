<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('inventories', function (Blueprint $table) {
			$table->id();
			$table->foreignId('kasi_id')->nullable()->constained()->cascadeOnUpdate()->onDelete('set null');
			$table->date('obtained_at');
			$table->string('name');
			$table->string('unit')->nullable();
			$table->bigInteger('price')->default(0);
			$table->string('from')->nullable();
			$table->string('label')->nullable();
			$table->text('description')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}
	
	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('inventories');
	}
}