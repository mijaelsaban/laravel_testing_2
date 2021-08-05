<?php


namespace App\Services\Transactions\Stripe;

use Carbon\Carbon;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Log;
use Stripe\BalanceTransaction;
use Stripe\Charge;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Stripe\StripeObject;

/**
 * Class FetchService
 * @package App\Services\Transactions\Stripe
 */
class FetchService implements FetchServiceInterface
{
    /**
     * @var CreateService
     */
    private $createService;
    /**
     * @var StripeClient
     */
    private $apiRequest;

    public function __construct(CreateServiceInterface $createService, ApiRequestInterface $apiRequest)
    {
        $this->createService = $createService;
        $this->apiRequest = $apiRequest;
    }

    /**
     */
    public function handle(int $dateFrom, int $dateTo): void
    {
        try {
            $transactions = $this->apiRequest->getTransactions($dateFrom, $dateTo);
            $this->createTransactions($transactions);
        } catch (\Exception $e) {
            Log::error(sprintf(
                'error: %strace: %s',
                $e->getMessage(),
                $e->getTraceAsString()
            ));

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Collection $transactions
     * @return void
     * @throws ApiErrorException
     */
    private function createTransactions(Collection $transactions): void
    {
        foreach ($transactions->autoPagingIterator() as $transaction) {
            Log::info('Stripe fetched reference:' . $this->getReference($transaction));
            /**
             * @var  BalanceTransaction $transaction
             */
            $charge = $this->apiRequest->getCharge($transaction);

            UserDetail::firstOrCreate(
                ['reference' => $this->getReference($transaction)],
                [
                    'provider_id' => 1,
                    'reference' => $this->getReference($transaction),
                    'type' => $transaction->type,
                    'currency_id' => $this->createService->getCurrencyId($transaction->currency),
                    'gross' => $transaction->amount / 100,
                    'fee' => $transaction->fee / 100,
                    'net' => $transaction->net / 100,
                    'description' => $transaction->description,
                    'conversion_rate' => $transaction->exchange_rate,
                    'charge_id' => $this->createService->getChargeId($charge),
                    'customer_facing_currency_id' => $this->createService->getCustomerCurrencyId($charge),
                    'customer_facing_amount' => $this->createService->getAmount($charge),
                    'customer_email' => $this->createService->getCustomerEmail($charge),
                    'customer_name' => $this->createService->getCustomerName($charge),
                    'shipping_address_line1' => $this->createService->getCustomerAddress1($charge),
                    'shipping_address_line2' => $this->createService->getCustomerAddress2($charge),
                    'shipping_address_city' => $this->createService->getCustomerCity($charge),
                    'shipping_address_state' => $this->createService->getCustomerState($charge),
                    'shipping_address_postal_code' => $this->createService->getCustomerPostalCode($charge),
                    'shipping_address_country' => $this->createService->getCustomerCountry($charge),
                    'metadata' => $this->createService->getMetaData($charge),
                    'transacted_at' => Carbon::createFromTimestamp($transaction->created, 'Europe/Vienna')
                ]
            );
        }
    }


    /**
     * @param BalanceTransaction $transaction
     * @return string|StripeObject
     */
    public function getReference(BalanceTransaction $transaction)
    {
        return $transaction->source ?? $transaction->id;
    }
}
