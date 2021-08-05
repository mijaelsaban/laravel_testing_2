<?php

namespace Database\Seeders;

use App\Models\TransactionEventCode;
use Illuminate\Database\Seeder;

class TransactionEventCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * From https://developer.paypal.com/docs/integration/direct/transaction-search/transaction-event-codes/#t00nn-paypal-account-to-paypal-account-payment
     * @return void
     */
    public function run()
    {
        foreach ($this->getEventCodes() as $code => $values) {
            TransactionEventCode::insertOrIgnore([
                'code' => $code,
                'description' => $values['description'],
                'transaction_type_id' => $values['transaction_type_id']
            ]);
        }
    }

    private function getEventCodes(): array
    {
        return [
            'T0001' => ['description' => 'MassPay payment.', 'transaction_type_id' => 1],
            'T1107' => ['description' => 'Payment refund, initiated by merchant.', 'transaction_type_id' => 2],
            'T1110' => ['description' => 'Hold for dispute investigation. To cover possible chargeback.', 'transaction_type_id' => 3],
            'T1111' => ['description' => 'Cancellation of hold for dispute resolution.', 'transaction_type_id' => 3],
            'T0400' => ['description' => 'General Withdrawal.', 'transaction_type_id' => 4],
            'T0004' => ['description' => 'eBay auction payment.', 'transaction_type_id' => 1],
            'T0005' => ['description' => 'Direct payment API.', 'transaction_type_id' => 1],
            'T0006' => ['description' => 'PayPal Checkout APIs.', 'transaction_type_id' => 1],
        ];
    }
}
