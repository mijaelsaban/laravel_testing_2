<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{


    private static $transactions = [
            [
                'reference' => 'ch_1IxpZtFmbigdF1QVmNrNOdwh',
                'reporting_category' => 'charge',
                'currency_id' => 1,
                'gross' => 64.36,
                'fee' => 2.12,
                'net' => 62.24,
                'description' => 'BFC BAMBINIFASHION.COM GmbH',
                'customer_facing_amount' => 1602,
                'customer_facing_currency_id' => 41,
                'customer_email' => 'gabbo21@testing.com',
                'customer_name' => 'Gabino Gutierrez',
                'shipping_address_line1' => 'Calle 24 con 25, TAB 97314, Residencial Allegra, Santa Gertrudis Copo',
                'shipping_address_line2' => 'Calle Murcia, Lote i5',
                'shipping_address_city' => 'Merida',
                'shipping_address_state' => 'Yucatán',
                'shipping_address_postal_code' => '97305',
                'shipping_address_postal_country' => 'MX',
                'payment_intent_id' => 'pi_1IxpZ7FmbigdF1QVrf67vbho',
                'transacted_at' => '2021-06-02 10:37:29',
            ]
        ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (self::$transactions as $transaction) {
            DB::table('transactions')->insert([
                'transaction_provider_id' => 1,
                'reference' => $transaction['reference'],
                'reporting_category' => $transaction['reporting_category'],
                'currency_id' => $transaction['currency_id'],
                'gross' => $transaction['gross'],
                'fee' => $transaction['fee'],
                'net' => $transaction['net'],
                'description' => $transaction['description'],
                'customer_facing_amount' => $transaction['customer_facing_amount'],
                'customer_facing_currency_id' => $transaction['customer_facing_currency_id'],
                'customer_email' => $transaction['customer_email'],
                'customer_name' => $transaction['customer_name'],
                'shipping_address_line1' => $transaction['shipping_address_line1'],
                'shipping_address_line2' => $transaction['shipping_address_line2'],
                'shipping_address_city' => $transaction['shipping_address_city'],
                'shipping_address_state' => $transaction['shipping_address_state'],
                'shipping_address_postal_code' => $transaction['shipping_address_postal_code'],
                'shipping_address_country' => $transaction['shipping_address_postal_country'],
                'payment_intent_id' => $transaction['payment_intent_id'],
                'metadata' => null,
                'transacted_at' => $transaction['transacted_at'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
