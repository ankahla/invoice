<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'user_id' => 1,
            'name' => 'Chèque',
        ]);

        DB::table('payments')->insert([
            'user_id' => 2,
            'name' => 'CB',
        ]);
    }
}