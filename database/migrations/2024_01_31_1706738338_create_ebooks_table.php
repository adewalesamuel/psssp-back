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
            $table->text('description')->nullable()->default('');
            $table->integer('price');
			$table->string('download_code')->nullable()->default('');
			$table->integer('initial_stock')->default(0);
			$table->string('img_url')->nullable()->default('');
			$table->string('file_url')->nullable()->default('');
            $table->boolean('is_public')->default(false);
            $table->foreignId('category_id')
            ->constrained()
            ->onDelete('cascade');
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
