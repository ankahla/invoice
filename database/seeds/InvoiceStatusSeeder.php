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
            'name' => 'paid',
        ]);

        DB::table('invoice_statuses')->insert([
            'name' => 'unpaid',
        ]);

        DB::table('invoice_statuses')->insert([
            'name' => 'partially paid',
        ]);

        DB::table('invoice_statuses')->insert([
            'name' => 'cancelled',
        ]);

        DB::table('invoice_statuses')->insert([
            'name' => 'overdue',
        ]);
    }
}