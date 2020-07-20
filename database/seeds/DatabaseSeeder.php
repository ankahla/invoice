<?php

use Illuminate\Database\Seeder;
use Database\seeds\UserSeeder;
use Database\seeds\UserSettingSeeder;
use Database\seeds\LanguageSeeder;
use Database\seeds\ProductSeeder;
use Database\seeds\ImageSeeder;
use Database\seeds\CurrencySeeder;
use Database\seeds\TaxSeeder;
use Database\seeds\PaymentSeeder;
use Database\seeds\ClientSeeder;
use Database\seeds\InvoiceStatusSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generals')->insert([
            'type' => 1,
            'version' => '1.1',
        ]);

        $this->call(UserSeeder::class);
        $this->call(UserSettingSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(InvoiceStatusSeeder::class);
    }
}
