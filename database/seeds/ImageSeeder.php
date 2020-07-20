<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            'user_id' => 1,
            'name' => 'default-logo.jpg',
        ]);

        DB::table('images')->insert([
            'user_id' => 2,
            'name' => 'default-logo.jpg',
        ]);
    }
}