<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
			$table->string('fullname');
			$table->string('email')->unique();
			$table->string('password')->unique();
			$table->string('phone_number')->unique();
			$table->string('backup_number')->unique();
			$table->string('whatsapp_number')->unique();
			$table->string('telegram_number')->unique();
			$table->string('shop_name')->unique();
			$table->string('profile_img_url')->nullable()->default('');
			$table->boolean('is_active')->default(false);
			$table->string('sponsor_code')->nullable()->default('');
			$table->string('referer_sponsor_code')->nullable()->default('');
			$table->string('activation_code')->nullable()->default('');
			$table->foreignId('country_id')
            ->nullable()
			->constrained()
			->nullOnDelete();
			$table->timestamp('email_verified_at')->nullable();
			$table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
