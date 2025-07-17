<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('organizations', function(Blueprint $table) {
			$table->id();
			$table->string('name')->index();
			$table->timestamps();
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('organizations');
	}
};
