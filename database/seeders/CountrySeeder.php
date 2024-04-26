<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            [
               'name' => 'Côte d\'Ivoire',
               'code' => 'CI',
               'phone_code' => '+225',
               'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
               'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
           ],
           [
               'name' => 'Bénin',
               'code' => 'BN',
               'phone_code' => '+229',
               'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
               'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
           ],
           [
               'name' => 'Burkina',
               'code' => 'BR',
               'phone_code' => '+226',
               'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
               'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
           ],
           [
               'name' => 'Mali',
               'code' => 'ML',
               'phone_code' => '+223',
               'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
               'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
           ],
           [
               'name' => 'Sénégal',
               'code' => 'SN',
               'phone_code' => '+221',
               'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
               'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
           ],
           [
               'name' => 'Togo',
               'code' => 'TG',
               'phone_code' => '+228',
               'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
               'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
           ]
        ]);
    }
}
