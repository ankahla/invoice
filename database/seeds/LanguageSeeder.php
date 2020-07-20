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
            'id' => 1,
            'name' => 'English',
            'short' => 'en',
        ]);

        DB::table('languages')->insert([
            'id' => 2,
            'name' => 'Frensh',
            'short' => 'fr',
        ]);

        DB::table('languages')->insert([
            'id' => 3,
            'name' => 'Arabe',
            'short' => 'ar',
        ]);
    }
}