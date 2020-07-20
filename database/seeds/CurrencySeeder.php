<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'user_id' => 1,
            'name' => 'DTN',
            'position' => 2,
        ]);

        DB::table('currencies')->insert([
            'user_id' => 2,
            'name' => 'EUR',
            'position' => 1,
        ]);
    }
}