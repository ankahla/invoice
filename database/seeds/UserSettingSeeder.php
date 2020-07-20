<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_settings')->insert([
            'user_id' => 1,
            'language_id' => 2,
            'currency_id' => 1,
            'name' => 'société',
            'country' => 'Tunisie',
            'state' => 'Sousse',
            'city' => 'Sahloul',
            'zip' => '4000',
            'address' => 'Avenue ....',
            'contact' => 'Foulan foulani',
            'phone' => '7894568776',
            'email' => 'demo@demo.fr',
            'website' => 'http://www.demo.com',
            'bank' => 'BNA',
            'bank_account' => 'TN59543765876576431',
            'description' => '',
            'status' => '1',
        ]);

        DB::table('user_settings')->insert([
            'user_id' => 2,
            'language_id' => 2,
            'currency_id' => 1,
            'name' => 'société',
            'country' => 'Tunisie',
            'state' => 'Sousse',
            'city' => 'Sahloul',
            'zip' => '4000',
            'address' => 'Avenue ....',
            'contact' => 'Foulan foulani',
            'phone' => '7894568776',
            'email' => 'demo@demo.fr',
            'website' => 'http://www.demo.com',
            'bank' => 'BNA',
            'bank_account' => 'TN59543765876576431',
            'description' => '',
            'status' => '1',
        ]);
    }
}