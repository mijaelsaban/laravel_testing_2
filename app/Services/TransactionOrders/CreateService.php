<?php

namespace App\Services\TransactionOrders;

use App\Models\UserDetail;
use App\Models\TransactionOrder;
use App\Models\PrestashopModels\PaypalOrder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\PrestashopModels\StripePayment;

/**
 * Class CreateService
 * @package App\Services\TransactionOrders
 */
class CreateService
{
    /**
     * @var UserDetail[]|Collection
     */
    private $transactions;

    public function handle(): CreateService
    {
        $this->getTransactions();

        $transactions = $this->transactions;
        $stripePayments = $this->getStripePayments();
        $paypalPayments = $this->getPaypalPayments();

        $this->mapPayments(
            $stripePayments->toArray(),
            $paypalPayments->toArray(),
            $transactions
        );

        return $this;
    }


    private function getTransactions(): void
    {
        $this->transactions = UserDetail::select(['transactions.id', 'provider_id', 'reference'])
            ->leftJoin(
                'transaction_orders',
                'transaction_id',
                'transactions.id'
            )
            ->where('type', 'charge')
            ->whereNull('transaction_orders.id')
            ->get();
    }

    public function getStripePayments(): \Illuminate\Support\Collection
    {
        return StripePayment::select([
            'id_order',
            'reference as order_reference',
            'orders.id_cart',
            'id_stripe',
            'total_paid',
            'orders.date_add'
        ])
            ->whereIn('id_stripe', $this->transactions->where('provider_id', 1)->pluck('reference'))
            ->leftJoin('orders', 'stripe_payment.id_cart', '=', 'orders.id_cart')
            ->whereNotNull('orders.id_order')
            ->get();
    }

    public function getPaypalPayments(): \Illuminate\Support\Collection
    {
        return PaypalOrder::select([
            'paypal_order.id_order',
            'id_transaction',
            'orders.id_cart',
            'currency',
            'paypal_order.total_paid as amount',
            'orders.reference as order_reference',
            'orders.total_paid as total_paid',
            'orders.date_add'
        ])
            ->whereIn('id_transaction', $this->transactions->where('provider_id', 2)->pluck('reference'))
            ->leftJoin('orders', 'paypal_order.id_order', '=', 'orders.id_order')
            ->whereNotNull('orders.id_order')
            ->get();
    }

    /**
     * @param array $stripePayments
     * @param array $paypalPayments
     * @param Collection $transactions
     */
    private function mapPayments(
        array $stripePayments,
        array $paypalPayments,
        Collection $transactions
    ): void
    {
        $this->manageStripe($stripePayments, $transactions);
        $this->managePaypal($paypalPayments, $transactions);
    }

    /**
     * @param array $stripePayments
     * @param Collection $transactions
     */
    private function manageStripe(array $stripePayments, Collection $transactions): void
    {
        foreach ($stripePayments as $key => $stripePayment) {
            if ($transactions->where('reference', $stripePayment['id_stripe'])->count() === 0) {
                continue;
            }

            $transactionId = $transactions->where('reference', $stripePayment['id_stripe'])->first()->id;
            TransactionOrder::firstOrCreate(['transaction_id' => $transactionId], [
                'transaction_id' => $transactionId,
                'order_reference' => $stripePayment['order_reference'],
                'order_id' => $stripePayment['id_order'],
                'order_value' => $stripePayment['total_paid'],
                'order_created_at' => $stripePayment['date_add']
            ]);
            dump($key, 'stripe');
        }
    }

    private function managePaypal(array $paypalPayments, Collection $transactions): void
    {
        foreach ($paypalPayments as $key => $paypalPayment) {
            if ($transactions->where('reference', $paypalPayment['id_transaction'])->count() === 0) {
                continue;
            }

            $transactionId = $transactions->where('reference', $paypalPayment['id_transaction'])->first()->id;
            TransactionOrder::firstOrCreate(['transaction_id' => $transactionId], [
                'transaction_id' => $transactionId,
                'order_reference' => $paypalPayment['order_reference'],
                'order_id' => $paypalPayment['id_order'],
                'order_value' => $paypalPayment['total_paid'],
                'order_created_at' => $paypalPayment['date_add']
            ]);
            dump($key, 'paypal');
        }
    }
}
