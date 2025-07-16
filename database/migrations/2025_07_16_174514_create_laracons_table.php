<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('laracons', function(Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->geometry('coordinates', subtype: 'point');
			$table->date('starts_at');
			$table->date('ends_at');
			$table->timestamps();
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('laracons');
	}
};
