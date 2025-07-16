<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('cell_towers', function(Blueprint $table) {
			$table->id();
			$table->string('radio');
			$table->geometry('coordinates', subtype: 'point');
			$table->unsignedBigInteger('range')->index();
			$table->timestamps();
			
			$table->spatialIndex('coordinates');
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('cell_towers');
	}
};
