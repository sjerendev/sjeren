<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::table('pages', function (Blueprint $table) {
			$table->integer('sort_order')->default(0);
		});
	}

	public function down()
	{
		Schema::table('pages', function (Blueprint $table) {
			$table->dropColumn('sort_order');
		});
	}
};
