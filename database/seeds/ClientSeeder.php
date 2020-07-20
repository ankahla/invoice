<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'user_id' => 1,
            'name' => 'SOCIETE  GENERAL  EQUIPEMENT',
            'country' => 'Tunisie',
            'state' => 'Tunis',
            'city' => 'RADES',
            'zip' => '6000',
            'address' => '-',
            'contact' => '.',
            'phone' => '71 464 831',
            'email' => 'contact@general.xn--quip-9oa.tn',
            'website' => '',
            'bank' => '',
            'bank_account' => '',
            'description' => '',
            'created_at' => '2016-02-01',
            'updated_at' => '2016-02-01',
        ]);

        DB::table('clients')->insert([
            'user_id' => 2,
            'name' => 'SOCIETE  GENERAL  EQUIPEMENT',
            'country' => 'Tunisie',
            'state' => 'Tunis',
            'city' => 'RADES',
            'zip' => '6000',
            'address' => '-',
            'contact' => '.',
            'phone' => '71 464 831',
            'email' => 'contact@general.xn--quip-9oa.tn',
            'website' => '',
            'bank' => '',
            'bank_account' => '',
            'description' => '',
            'created_at' => '2016-02-01',
            'updated_at' => '2016-02-01',
        ]);

    }
}