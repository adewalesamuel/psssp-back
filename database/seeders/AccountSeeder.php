<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'email' => 'solidarite',
            'fullname' => 'Solidarite',
            'password' => Hash::make('solidarite'),
            'backup_number' => '000000000',
            'whatsapp_number' => '000000000',
            'telegram_number' => '000000000',
            'shop_name' => 'Solidarite',
            'is_active' => true,
            'api_token' => Str::random(60),
            'user_id' => DB::table('users')->where('sponsor_code', '=', 'CP000000')->first()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
