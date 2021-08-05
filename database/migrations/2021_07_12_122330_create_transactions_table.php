<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('provider_id');
            $table->string('reference')
                ->index()
                ->unique();
            $table->string('type');
            $table->unsignedTinyInteger('currency_id')->index();
            $table->decimal('gross');
            $table->decimal('fee');
            $table->decimal('net');
            $table->string('description')->nullable();
            $table->string('charge_id')
                ->index()
                ->nullable();
            $table->decimal('customer_facing_amount')->nullable();
            $table->unsignedTinyInteger('customer_facing_currency_id')->nullable();
            $table->decimal('conversion_rate', 13, 6)->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('shipping_address_line1')->nullable();
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_address_city')->nullable();
            $table->string('shipping_address_state')->nullable();
            $table->string('shipping_address_postal_code')->nullable();
            $table->string('shipping_address_country', 3)->nullable();
            $table->json('metadata')->nullable();

            $table->timestamp('transacted_at');
            $table->timestamps();

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
