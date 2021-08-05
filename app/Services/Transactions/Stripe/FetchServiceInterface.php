<?php

namespace App\Services\Transactions\Stripe;

/**
 * Class FetchService
 * @package App\Services\Transactions\Stripe
 */
interface FetchServiceInterface
{
    public function handle(int $dateFrom, int $dateTo): void;
}
