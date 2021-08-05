<?php


namespace App\Services\Transactions\Stripe;

use Stripe\Charge;
use Stripe\StripeObject;
use App\Models\PrestashopModels\Currency;

/**
 * Class CreateService
 * @package App\Services\Transactions\Stripe
 */
final class CreateService implements CreateServiceInterface
{
    public function getCurrencyId(string $currency): int
    {
        return Currency::where('iso_code', mb_strtoupper($currency))
            ->first()->id_currency;
    }

    /**
     * @param Charge|null $charge
     * @return float|int
     */
    public function getAmount(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        return $charge->amount / 100;
    }

    /**
     * @param Charge|null $charge
     * @return int
     */
    public function getCustomerCurrencyId(?Charge $charge): ?int
    {
        if (!$charge) {
            return null;
        }

        return $this->getCurrencyId($charge->currency);
    }

    /**
     * @param Charge|null $charge
     * @return mixed|null
     */
    public function getCustomerEmail(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        return $charge->billing_details->email;
    }

    /**
     * @param Charge|null $charge
     * @return mixed|null
     */
    public function getCustomerName(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        return $charge->billing_details->name;
    }

    /**
     * @param Charge|null $charge
     * @return mixed
     */
    public function getCustomerAddress1(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        $charge = $this->getIfNoShipping($charge);

        return $charge->address->line1;
    }

    /**
     * @param Charge|null $charge
     * @return mixed
     */
    public function getCustomerAddress2(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        $charge = $this->getIfNoShipping($charge);

        return $charge->address->line2;
    }

    /**
     * @param Charge|null $charge
     * @return mixed
     */
    public function getCustomerCity(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        $charge = $this->getIfNoShipping($charge);

        return $charge->address->city;
    }

    /**
     * @param Charge|null $charge
     * @return mixed
     */
    public function getCustomerState(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        $charge = $this->getIfNoShipping($charge);

        return $charge->address->state;
    }

    /**
     * @param Charge|null $charge
     * @return mixed
     */
    public function getCustomerPostalCode(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        $charge = $this->getIfNoShipping($charge);

        return $charge->address->postal_code;
    }

    /**
     * @param Charge|null $charge
     * @return mixed
     */
    public function getCustomerCountry(?Charge $charge)
    {
        if (!$charge) {
            return null;
        }

        $charge = $this->getIfNoShipping($charge);

        return $charge->address->country;
    }


    /**
     * @param Charge|StripeObject|null $charge
     * @return false|string
     */
    public function getMetaData(?Charge $charge)
    {
        if (!$charge || !isset($charge->metadata)) {
            return null;
        }

        return json_encode($charge->metadata->toArray());
    }


    /**
     * @param Charge|StripeObject|null $charge
     * @return Charge|StripeObject
     */
    public function getIfNoShipping(Charge $charge)
    {
        return $charge->shipping ?? $charge->billing_details;
    }

    public function getChargeId(?Charge $charge): ?string
    {
        if (!$charge) {
            return null;
        }

        return $charge->id;
    }
}
