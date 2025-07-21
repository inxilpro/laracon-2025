<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('coffee_shops', function(Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->integer('star_rating')->default(2);
			$table->geometry('location', subtype: 'point');
			$table->timestamps();
			
			if (DB::getQueryGrammar() instanceof MySqlGrammar) {
				$table->spatialIndex('location');
			}
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('coffee_shops');
	}
};
