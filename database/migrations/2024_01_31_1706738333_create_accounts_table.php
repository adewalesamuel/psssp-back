<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('password')->unique();
            $table->string('backup_number');
            $table->string('whatsapp_number');
            $table->string('telegram_number');
            $table->string('shop_name')->unique();
            $table->string('profile_img_url')->nullable()->default('');
            $table->boolean('is_active')->default(false);
            $table->string('referer_sponsor_code')->nullable()->default('');
            $table->string('activation_code')->nullable()->default('');
            $table->string('api_token')->unique()->nullable();
            $table->foreignId('country_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();            
            $table->foreignId('user_id')
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
        Schema::dropIfExists('accounts');
    }
}
