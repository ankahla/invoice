<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'user_id' => 1,
            'name' => 'Travaux réparation',
            'code' => 'IB8373-EH',
            'price' => 150.033,
            'description' => 'Travaux de préparation de lignes téléphonique au DAB "Polluia Ezzahra"',
            'status' => 1,
            'updated_at' => '2015-09-12',
            'created_at' => '2015-09-12',
        ]);

        DB::table('products')->insert([
            'user_id' => 1,
            'name' => 'Poste  Panasonic  numérique  24 boutons  programmable   avec  afficheur.',
            'code' => '002',
            'price' => 200,
            'description' => '',
            'status' => 1,
            'updated_at' => '2015-12-09',
            'created_at' => '2015-12-09',
        ]);
    }
}