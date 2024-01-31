<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('slug')->unique();
			$table->enum('type', ['private', 'public']);
			$table->string('download_code')->nullable()->default('');
			$table->text('description')->nullable()->default('');
			$table->integer('price');
			$table->integer('initial_stock')->default(0);
			$table->string('img_url')->nullable()->default('');
			$table->string('file_url')->nullable()->default('');
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
        Schema::dropIfExists('ebooks');
    }
}
