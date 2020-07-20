<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->insert([
            'user_id' => 1,
            'value' => 20.000,
        ]);

        DB::table('taxes')->insert([
            'user_id' => 1,
            'value' => 18.000,
        ]);

        DB::table('taxes')->insert([
            'user_id' => 2,
            'value' => 19.000,
        ]);
    }
}