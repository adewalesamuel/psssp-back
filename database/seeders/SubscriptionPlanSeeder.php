<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscription_plans')->insert([
            [
                'name' => 'Plan Super Simple',
                'slug' => Str::slug('Plan Super Simple'),
                'price' => 0,
                'description' => 'Description',
                'num_product' => 7,
                'num_account' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Plan Super Pro',
                'slug' => Str::slug('Plan Super Pro'),
                'price' => 0,
                'description' => 'Description',
                'num_product' => 10,
                'num_account' => 11,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Plan Pro Max',
                'slug' => Str::slug('Plan Pro Max'),
                'price' => 0,
                'description' => 'Description',
                'num_product' => 15,
                'num_account' => 21,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Plan Pro Max Or',
                'slug' => Str::slug('Plan Pro Max Or'),
                'price' => 0,
                'description' => 'Description',
                'num_product' => 20,
                'num_account' => 31,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Plan Pro Max Diamant',
                'slug' => Str::slug('Plan Pro Max Diamant'),
                'price' => 0,
                'description' => 'Description',
                'num_product' => 25,
                'num_account' => 41,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
