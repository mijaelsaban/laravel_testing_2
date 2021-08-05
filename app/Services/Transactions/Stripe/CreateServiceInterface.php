<?php

namespace App\Services\Transactions\Stripe;

use Stripe\Charge;
use Stripe\StripeObject;

/**
 * Class CreateService
 * @package App\Services\Transactions\Stripe
 */
interface CreateServiceInterface
{
    public function getCurrencyId(string $currency): int;

    /**
     * @param Charge|null $charge
     * @return float|int
     */
    public function getAmount(?Charge $charge);

    /**
     * @param Charge|null $charge
     * @return int
     */
    public function getCustomerCurrencyId(?Charge $charge): ?int;

    /**
     * @param Charge|null $charge
     * @return mixed|null
     */
    public function getCustomerEmail(?Charge $charge);

    /**
     * @param Charge|null $charge
     * @return mixed|null
     */
    public function getCustomerName(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return mixed
     */
    public function getCustomerAddress1(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return mixed
     */
    public function getCustomerAddress2(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return mixed
     */
    public function getCustomerCity(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return mixed
     */
    public function getCustomerState(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return mixed
     */
    public function getCustomerPostalCode(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return mixed
     */
    public function getCustomerCountry(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return false|string
     */
    public function getMetaData(?Charge $charge);

    /**
     * @param Charge|StripeObject|null $charge
     * @return Charge|StripeObject
     */
    public function getIfNoShipping(Charge $charge);

    public function getChargeId(?Charge $charge): ?string;
}
