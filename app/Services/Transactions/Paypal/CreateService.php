<?php


namespace App\Services\Transactions\Paypal;

use App\Models\TransactionEventCode;
use App\Models\PrestashopModels\Currency;
use JsonException;

/**
 * Class CreateService
 * @package App\Services\Transactions\Paypal
 */
final class CreateService
{
    public function getTransactionType(string $code, int $amount): string
    {
        $transactionEventCode = TransactionEventCode::where('code', $code)
            ->first();

        if ($amount < 0 && $code === 'T0006') {
            return 'withdrawal';
        }

        return $transactionEventCode->type->name ?? 'other';
    }

    public function getCurrencyId(string $currency): int
    {
        return Currency::where('iso_code', mb_strtoupper($currency))
            ->first()->id_currency;
    }


    /**
     * @return mixed|null
     */
    public function getCustomerName(?object $transactionDetail): ?string
    {
        if (!isset($transactionDetail->shipping_info->name)) {
            return null;
        }

        return $transactionDetail->shipping_info->name ?? null;
    }

    /**
     * @param object|null $transactionDetail
     * @return mixed
     */
    public function getCustomerAddress1(?object $transactionDetail): ?string
    {
        if (!isset($transactionDetail->shipping_info->address)) {
            return null;
        }

        return $transactionDetail->shipping_info->address->line1 ?? null;
    }

    /**
     * @param object|null $transactionDetail
     * @return mixed
     */
    public function getCustomerCity(?object $transactionDetail)
    {
        if (!isset($transactionDetail->shipping_info->address)) {
            return null;
        }

        return $transactionDetail->shipping_info->address->city;
    }

    /**
     * @param object|null $transactionDetail
     * @return mixed
     */
    public function getCustomerPostalCode(?object $transactionDetail)
    {
        return $transactionDetail->shipping_info->address->postal_code ?? null;
    }

    /**
     * @param object|null $transactionDetail
     * @return false|string
     * @throws JsonException
     */
    public function getMetaData(?object $transactionDetail)
    {
        return isset($transactionDetail->cart_info->item_details) ?
            json_encode($transactionDetail->cart_info->item_details, JSON_THROW_ON_ERROR) : null;
    }

    public function getFee($transactionDetail): int
    {
        return $transactionDetail->transaction_info->fee_amount->value ?? 0;
    }

    public function getNet(int $fee, int $gross): int
    {
        return $fee ? $gross + $fee : 0;
    }
}
