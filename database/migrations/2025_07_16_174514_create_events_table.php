<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('events', function(Blueprint $table) {
			$table->id();
			$table->foreignId('organization_id');
			$table->string('title');
			$table->geometry('location', subtype: 'point');
			$table->string('speaker_ids');
			$table->timestamps();
			
			if (DB::getQueryGrammar() instanceof MySqlGrammar) {
				$table->spatialIndex('location');
			}
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('events');
	}
};
