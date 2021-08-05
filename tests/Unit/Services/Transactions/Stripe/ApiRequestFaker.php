<?php

namespace Tests\Unit\Services\Transactions\Stripe;

use Stripe\Charge;
use Stripe\Collection;
use Stripe\BalanceTransaction;
use App\Services\Transactions\Stripe\ApiRequestInterface;

class ApiRequestFaker implements ApiRequestInterface
{

    public function getTransactions(int $dateFrom, int $dateTo): Collection
    {
        return Collection::constructFrom(
            [
                'object' => 'list',
                'data' => [
                    [
                        'id' => 'txn_3JJvp5FmbigdF1QV0IpE7YGU',
                        'object' => 'balance_transaction',
                        'amount' => '25530',
                        'available_on' => '1628121600',
                        'created' => '1627890273',
                        'currency' => 'eur',
                        'description' => 'eur',
                        'exchange_rate' => ' 0.606405',
                        'fee' => ' 765',
                        'fee_details' => [
                            'amount' => '2'
                        ],
                        'net' => ' 24765',
                        'reporting_category' => 'charge',
                        'source' => 'ch_3JJvp5FmbigdF1QV09nKtlzz',
                        'status' => 'pending',
                        'type' => 'charge',
                    ]
                ],
                'has_more' => false
            ]
        );
    }

    public function getCharge(BalanceTransaction $transaction): ?Charge
    {

        $charge = new Charge();

        $charge->updateAttributes([
            'id' => "ch_1IzQyOFmbigdF1QVIMWnqkhj",
            'object' => "charge",
            'amount' => 6000,
            'amount_captured' => 6000,
            'amount_refunded' => 6000,
            'application' => null,
            'application_fee' => null,
            'application_fee_amount' => null,
            'balance_transaction' => "txn_1IzQyPFmbigdF1QVlDaONiOH",
            'billing_details' => (object)[
                'email' => 'test@test.com',
                'name' => 'carlos'
            ],
            'address' => (object)[
                'line1' => 'hofzeile 12312',
                'line2' => 'saturn tower',
                'city' => 'Neverland',
                'state' => 'carlos state',
                'postal_code' => '1190',
                'country' => 'Uk',
            ],
            'shipping' => [
                'address' => (object)[
                    'line1' => 'hofzeile 12312',
                    'line2' => 'saturn tower',
                    'city' => 'Neverland',
                    'state' => 'carlos state',
                    'postal_code' => '1190',
                    'country' => 'Uk',]
            ],
            'calculated_statement_descriptor' => "BAMBINIFASHION.COM",
            'captured' => true,
            'created' => 1623005124,
            'currency' => "gbp",
            'customer' => "cus_JcgKLe1oqS9fRL",
            'description' => "BFC BAMBINIFASHION.COM GmbH",
            'destination' => null,
            'dispute' => null,
            'disputed' => false,
            'failure_code' => null,
            'failure_message' => null,
            'fraud_details' => '',
            'invoice' => null,
            'livemode' => true,
            'metadata' => '',
            'on_behalf_of' => null,
            'order' => null,
            'outcome' => '',
            'paid' => true,
            'payment_intent' => "pi_1IzQyIFmbigdF1QV4PCOihhs",
            'payment_method' => "pm_1IzQyJFmbigdF1QVIbUqgJAG",
            'payment_method_details' => '',
            'receipt_email' => null,
            'receipt_number' => null,
            'receipt_url' => "https://pay.stripe.com/receipts/acct_19pGy8FmbigdF1QV/ch_1IzQyOFmbigdF1QVIMWnqkhj/rcpt_JcgLiBRdHTvsXd2VlhPK3l9MCxxlpv3",
            'refunded' => true,
            'refunds' => '',
            'review' => null,
            'source' => null,
            'source_transfer' => null,
            'statement_descriptor' => null,
            'statement_descriptor_suffix' => null,
            'status' => "succeeded",
            'transfer_data' => null,
            'transfer_group' => null,
            'metadata' => null
        ]);

        return $charge;
    }
}
