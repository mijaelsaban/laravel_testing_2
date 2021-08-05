<?php

namespace App\Services\TransactionRefunds;

use App\Models\UserDetail;
use App\Models\TransactionRefund;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\PrestashopModels\AccRefundedOrdersHistory;

/**
 * Class CreateService
 * @package App\Services\TransactionRefunds
 */
class CreateService
{
    public const TYPE_REFUND = 'refund';
    /**
     * @var UserDetail[]|Collection
     */
    private $transactions;

    public function handle(): CreateService
    {
        $this->getTransactions();

        $transactions = $this->transactions;

        $refunds = $this->getRefunds();

        $transactionRefunds = $this->matchRefunds($refunds, $transactions);

        $this->createTransactionRefunds($transactionRefunds->toArray());

        return $this;
    }


    private function getTransactions(): void
    {
        $this->transactions = UserDetail::select([
            'provider_id',
            'transactions.id',
            'reference',
            'charge_id'
        ])
            ->leftJoin(
                'transaction_refunds',
                'transaction_id',
                'transactions.id'
            )
            ->where('type', self::TYPE_REFUND)
            ->whereNull('transaction_refunds.id')
            ->get();
    }

    public function getRefunds(): SupportCollection
    {
        return AccRefundedOrdersHistory::select([
            'acc_refunded_orders_history.id_order',
            'acc_refunded_orders_history.amount',
            'id_stripe',
            'id_transaction',
            'reference',
            'orders.date_add',
            'orders.total_paid',
            'created_at'
        ])
            ->leftJoin(
                'orders',
                'acc_refunded_orders_history.id_order',
                '=',
                'orders.id_order'
            )
            ->leftJoin(
                'stripe_payment',
                function (JoinClause $join) {
                    $join->on('stripe_payment.id_cart', '=', 'orders.id_cart')
                        ->whereIn(
                            'id_stripe',
                            $this->transactions
                                ->where('provider_id', 1)
                                ->pluck('charge_id')
                        );
                }
            )
            ->leftJoin(
                'paypal_order',
                function (JoinClause $join) {
                    $join->on('paypal_order.id_order', '=', 'orders.id_order')
                    ->whereIn(
                        'id_transaction',
                        $this->transactions
                            ->where('provider_id', 2)
                            ->pluck('charge_id')
                    );
                }
            )
            ->whereNotNull('stripe_payment.id_cart')
            ->orWhereNotNull('paypal_order.id_order')
            ->get();
    }

    /**
     * @param array $transactionRefunds
     */
    public function createTransactionRefunds(array $transactionRefunds): void
    {
        foreach ($transactionRefunds as $transactionRefund) {
            TransactionRefund::firstOrCreate(['transaction_id' => $transactionRefund['transaction_id']], [
                'transaction_id' => $transactionRefund['transaction_id'],
                'order_reference' => $transactionRefund['order_reference'] ?? null,
                'amount' => $transactionRefund['amount'] ?? null,
                'order_id' => $transactionRefund['order_id'] ?? null,
                'order_value' => $transactionRefund['order_value'] ?? null,
                'refunded_at' => $transactionRefund['order_created_at'] ?? null
            ]);
        }
    }

    /**
     * @param SupportCollection $refunds
     * @param $transactions
     * @return SupportCollection
     */
    protected function matchRefunds(SupportCollection $refunds, $transactions): SupportCollection
    {
        return $refunds->map(function ($refund) use ($transactions) {
            $transactionId = $refund->id_stripe ?? $refund->id_transaction;
            if ($transactions->where('charge_id', $transactionId)->count() > 0) {
                return [
                    'transaction_id' => $transactions->where('charge_id', $transactionId)->first()->id,
                    'order_reference' => $refund->reference ?? null,
                    'amount' => $refund->amount,
                    'order_id' => $refund->id_order ?? null,
                    'order_value' => $refund->total_paid ?? null,
                    'refunded_at' => $refund->created_at ?? null
                ];
            }
        });
    }
}


