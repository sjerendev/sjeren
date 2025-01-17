<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('pages', function (Blueprint $table) {
			$table->string('meta_title')->nullable();
			$table->text('meta_description')->nullable();
		});

		Schema::table('posts', function (Blueprint $table) {
			$table->string('meta_title')->nullable();
			$table->text('meta_description')->nullable();
		});
	}

	public function down(): void
	{
		Schema::table('pages', function (Blueprint $table) {
			$table->dropColumn(['meta_title', 'meta_description']);
		});

		Schema::table('posts', function (Blueprint $table) {
			$table->dropColumn(['meta_title', 'meta_description']);
		});
	}
};
