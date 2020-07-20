<?php
namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoice_statuses')->insert([
            'id' => 1,
            'name' => 'paid',
        ]);

        DB::table('invoice_statuses')->insert([
            'id' => 2,
            'name' => 'unpaid',
        ]);

        DB::table('invoice_statuses')->insert([
            'id' => 3,
            'name' => 'partially paid',
        ]);

        DB::table('invoice_statuses')->insert([
            'id' => 4,
            'name' => 'cancelled',
        ]);

        DB::table('invoice_statuses')->insert([
            'id' => 5,
            'name' => 'overdue',
        ]);
    }
}