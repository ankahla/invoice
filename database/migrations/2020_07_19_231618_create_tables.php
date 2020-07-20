<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->string('name', '255');
            $table->string('country', '255');
            $table->string('state', '255');
            $table->string('city', '255');
            $table->string('zip', '100');
            $table->string('address', '255');
            $table->string('contact', '255');
            $table->string('phone', '20');
            $table->string('email', '255');
            $table->string('website', '255');
            $table->string('bank', '255');
            $table->string('bank_account', '255');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->string('name', '255');
            $table->unsignedTinyInteger('position');
        });

        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type');
            $table->string('version', '10');
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->string('name', '255');
        });

        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('client_id')->index('client_id_idx');
            $table->unsignedTinyInteger('status');
        });

        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('invoice_id')->index('invoice_id_idx');
            $table->unsignedInteger('payment_id')->index('payment_id_idx');
            $table->date('payment_date');
            $table->double('payment_amount', 10, 3, true);
        });

        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('invoice_id')->index('invoice_id_idx');
            $table->unsignedInteger('product_id')->index('product_id_idx');
            $table->unsignedInteger('quantity');
            $table->double('price', 10, 3, true);
            $table->double('tax', 10, 3, true);
            $table->double('discount', 10, 3, true);
            $table->unsignedTinyInteger('discount_type');
            $table->double('discount_value', 10, 3, true);
            $table->double('amount', 10, 3, true);
        });

        Schema::create('invoice_receiveds', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('invoice_id')->index('invoice_id_idx');
            $table->unsignedTinyInteger('status');
        });

        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('number');
            $table->string('code', '255');
            $table->text('text');
        });

        Schema::create('invoice_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('client_id')->index('client_id_idx');
            $table->unsignedInteger('status_id')->index('status_id_idx');
            $table->unsignedInteger('currency_id')->index('currency_id_idx');
            $table->unsignedInteger('number');
            $table->double('amount', 10, 3, true);
            $table->double('discount', 10, 3, true);
            $table->double('revenue_stamp', 10, 3, true);
            $table->unsignedTinyInteger('type');
            $table->text('description');
            $table->date('start_date');
            $table->date('due_date');
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', '255');
            $table->string('short', '100');
        });

        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->string('title', '255');
            $table->text('content');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->string('name', '255');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->string('name', '255');
            $table->string('code', '255');
            $table->double('price', 10, 3, true);
            $table->text('description', '255');
            $table->unsignedTinyInteger('status');
            $table->timestamps();
        });

        Schema::create('products_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->index('product_id_idx');
            $table->string('name', '255');
        });

        Schema::create('quotation_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('quotation_id')->index('quotation_id_idx');
            $table->unsignedInteger('product_id')->index('product_id_idx');
            $table->unsignedInteger('quantity');
            $table->double('price', 10, 3, true);
            $table->double('tax', 10, 3, true);
            $table->double('discount', 10, 3, true);
            $table->unsignedTinyInteger('duscount_type');
            $table->double('discount_value', 10, 3, true);
            $table->double('amount', 10, 3, true);
        });

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('client_id')->index('client_id_idx');
            $table->unsignedInteger('status_id')->index('status_id_idx');
            $table->unsignedInteger('currency_id')->index('currency_id_idx');
            $table->unsignedInteger('number');
            $table->double('amount', 10, 3, true);
            $table->double('discount', 10, 3, true);
            $table->double('revenue_stamp', 10, 3, true);
            $table->unsignedTinyInteger('type');
            $table->text('description');
            $table->date('start_date');
            $table->date('due_date');
            $table->timestamps();
        });

        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->double('value', 10, 3, true);
        });

        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id_idx');
            $table->unsignedInteger('language_id')->index('language_id_idx')->nullable();
            $table->unsignedInteger('currency_id')->index('currency_id_idx');
            $table->string('name', '255');
            $table->string('country', '255');
            $table->string('state', '255');
            $table->string('city', '255');
            $table->string('zip', '255');
            $table->string('address', '255');
            $table->string('contact', '255');
            $table->string('phone', '255');
            $table->string('email', '255');
            $table->string('website', '255');
            $table->string('bank', '255');
            $table->string('bank_account', '255');
            $table->text('description');
            $table->unsignedTinyInteger('status');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('generals');
        Schema::dropIfExists('images');
        Schema::dropIfExists('invitations');
        Schema::dropIfExists('invoice_payments');
        Schema::dropIfExists('invoice_products');
        Schema::dropIfExists('invoice_receiveds');
        Schema::dropIfExists('invoice_settings');
        Schema::dropIfExists('invoice_statuses');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_images');
        Schema::dropIfExists('quotation_products');
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('user_settings');
    }
}
