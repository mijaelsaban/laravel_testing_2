<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('transaction_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transaction_id')
                ->index();
            $table->string('order_reference', 9);
            $table->unsignedInteger('order_id')->index();
            $table->decimal('order_value', 20, 6);
            $table->timestamp('order_created_at')->index();

            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');

            $table->unique(['transaction_id', 'order_reference']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_orders');
    }
}
