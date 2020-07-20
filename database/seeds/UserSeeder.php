<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'role_id' => 1,
            'email' => 'admin@demo.demo',
            'password' => '$2y$10$doxa3f3PHtsVZOGqRQ9R5.meyetZw5eWT9R7PQ7C6ZYmNYP3tvHxG',
            'status' => 1,
            'remember_token' => null,
            'updated_at' => '2020-07-19',
            'created_at' => '2014-11-20',
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'role_id' => 2,
            'email' => 'user@demo.demo',
            'password' => '$2y$10$doxa3f3PHtsVZOGqRQ9R5.meyetZw5eWT9R7PQ7C6ZYmNYP3tvHxG',
            'status' => 1,
            'remember_token' => null,
            'updated_at' => '2020-07-19',
            'created_at' => '2014-11-20',
        ]);

    }
}