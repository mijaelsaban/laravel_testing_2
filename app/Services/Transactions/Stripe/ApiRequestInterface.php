<?php

namespace App\Services\Transactions\Stripe;

use Stripe\BalanceTransaction;
use Stripe\Charge;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;

interface ApiRequestInterface
{
    /**
     * @param int $dateFrom
     * @param int $dateTo
     * @return Collection
     * @throws ApiErrorException
     */
    public function getTransactions(int $dateFrom, int $dateTo): Collection;

    /**
     * @param BalanceTransaction $transaction
     * @return Charge
     * @throws ApiErrorException
     */
    public function getCharge(BalanceTransaction $transaction): ?Charge;
}
