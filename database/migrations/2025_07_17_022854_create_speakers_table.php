<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('speakers', function(Blueprint $table) {
			$table->id();
			$table->string('name')->index();
			$table->string('twitter')->nullable();
			$table->string('bsky')->nullable();
			$table->timestamps();
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('speakers');
	}
};
