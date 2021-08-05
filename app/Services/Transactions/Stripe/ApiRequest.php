<?php

namespace App\Services\Transactions\Stripe;

use Stripe\Charge;
use Stripe\Collection;
use Stripe\StripeClient;
use Stripe\BalanceTransaction;
use Stripe\Exception\ApiErrorException;

class ApiRequest implements ApiRequestInterface
{
    /**
     * @var StripeClient
     */
    private $stripeClient;

    public function __construct(StripeClient $stripeClient)
    {
        $this->stripeClient = $stripeClient;
    }

    /**
     * @param int $dateFrom
     * @param int $dateTo
     * @return Collection
     * @throws ApiErrorException
     */
    public function getTransactions(int $dateFrom, int $dateTo): Collection
    {
        $parameters = [
            'created[gte]' => $dateFrom,
            'created[lte]' => $dateTo,
            'limit' => 100,
        ];

        return $this->stripeClient->balanceTransactions->all($parameters);
    }

    /**
     * @param BalanceTransaction $transaction
     * @return Charge
     * @throws ApiErrorException
     */
    public function getCharge(BalanceTransaction $transaction): ?Charge
    {
        if ($transaction->type === 'charge') {
            return $this->stripeClient->charges->retrieve($transaction->source);
        }

        if ($transaction->type === 'refund') {
            $refund = $this->stripeClient->refunds->retrieve($transaction->source);
            return $this->stripeClient->charges->retrieve($refund->charge);
        }

        return null;
    }
}
