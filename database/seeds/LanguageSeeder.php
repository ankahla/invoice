<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name' => 'English',
            'short' => 'en',
        ]);

        DB::table('languages')->insert([
            'name' => 'Frensh',
            'short' => 'fr',
        ]);
    }
}