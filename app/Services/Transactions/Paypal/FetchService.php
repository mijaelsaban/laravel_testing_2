<?php


namespace App\Services\Transactions\Paypal;

use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use JsonException;
use PayPalHttp\HttpResponse;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use App\Libraries\Paypal\TransactionsGetRequest;

/**
 * Class FetchService
 * @package App\Services\Transactions\Paypal
 */
class FetchService
{
    public const PAGE_SIZE = 500;

    /**
     * @param $client
     * @param $createService
     * @param string $dateFrom
     * @param string $dateTo
     * @throws JsonException
     */
    public function handle($client, $createService, string $dateFrom, string $dateTo): void
    {
        $start_date = $dateFrom;
        $end_date = $dateTo;
        $fields = 'all';
        $pageSize = self::PAGE_SIZE;
        $page = 1;

        $totalPages = $this->getResponseByPage(
            $client,
            $start_date,
            $end_date,
            $fields,
            $pageSize,
            $page,
            $createService
        );

        if ($totalPages === 1) {
            return;
        }

        for ($page = 1; $page <= $totalPages; $page++) {
            $this->getResponseByPage($client, $start_date, $end_date, $fields, $pageSize, $page, $createService);
        }
    }

    /**
     * @param PayPalHttpClient $client
     * @param $startDate
     * @param $endDate
     * @param string $fields
     * @param int $pageSize
     * @param int $page
     * @return HttpResponse
     */
    private function getPaypalResponse(
        PayPalHttpClient $client,
        $startDate,
        $endDate,
        string $fields,
        int $pageSize,
        int $page
    ): HttpResponse {
        return $client->execute(app(
            TransactionsGetRequest::class,
            ['query' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'fields' => $fields ?? 'all',
                'page_size' => $pageSize,
                'page' => $page,
                //                                'transaction_id' => '3P019114VC809840R'
                //                'transaction_type' => 'T1107' //refund
            ]]
        ));
    }

    /**
     * @param PayPalHttpClient $client
     * @param string $start_date
     * @param string $end_date
     * @param string $fields
     * @param int $pageSize
     * @param int $page
     * @param CreateService $createService
     * @return mixed
     * @throws JsonException
     */
    private function getResponseByPage(
        PayPalHttpClient $client,
        string $start_date,
        string $end_date,
        string $fields,
        int $pageSize,
        int $page,
        CreateService $createService
    ) {
        $response = $this->getPaypalResponse(
            $client,
            $start_date,
            $end_date,
            $fields,
            $pageSize,
            $page
        );

        $result = $this->getResult($response);
        $totalPages = $result->total_pages;

        $this->createTransactions($result, $createService);
        return $totalPages;
    }

    /**
     * @param HttpResponse $response
     * @return object
     */
    private function getResult(HttpResponse $response): object
    {
        return (object)$response->result;
    }

    /**
     * @param object $result
     * @param CreateService $createService
     * @throws JsonException
     */
    private function createTransactions(object $result, CreateService $createService): void
    {
        if ($result) {
            foreach ($result->transaction_details as $transactionDetail) {
                Log::info(sprintf(
                    "Paypal fetched reference: %s",
                    $transactionDetail->transaction_info->transaction_id
                ));

                $gross = $transactionDetail->transaction_info->transaction_amount->value;
                $fee = $createService->getFee($transactionDetail);

                UserDetail::firstOrCreate(
                    ['reference' => $transactionDetail->transaction_info->transaction_id],
                    [
                        'provider_id' => 2,
                        'reference' => $transactionDetail->transaction_info->transaction_id,
                        'type' => $createService->getTransactionType(
                            $transactionDetail->transaction_info->transaction_event_code,
                            $gross
                        ),
                        'currency_id' => $createService->getCurrencyId(
                            $transactionDetail->transaction_info->transaction_amount->currency_code
                        ),
                        'gross' => $gross,
                        'fee' => $fee,
                        'net' => $createService->getNet($fee, $gross),
                        'description' => $transactionDetail->transaction_info->transaction_event_code,
                        'charge_id' => $transactionDetail->transaction_info->paypal_reference_id ?? null,
                        'customer_facing_amount' => null,
                        'customer_facing_currency_id' => null,
                        'conversion_rate' => null,
                        'customer_email' => $transactionDetail->payer_info->email_address ?? null,
                        'customer_name' => $createService->getCustomerName($transactionDetail),
                        'shipping_address_line1' => $createService->getCustomerAddress1($transactionDetail),
                        'shipping_address_line2' => null,
                        'shipping_address_city' => $createService->getCustomerCity($transactionDetail),
                        'shipping_address_postal_code' => $createService->getCustomerPostalCode($transactionDetail),
                        'shipping_address_country' => $transactionDetail->shipping_info->address->country_code ?? null,
                        'metadata' => null,
                        'transacted_at' => $this->getSetTimezone($transactionDetail),
                    ]
                );
            }
        }
    }

    /**
     * @param $transactionDetail
     * @return Carbon
     */
    private function getSetTimezone($transactionDetail): Carbon
    {
        return Carbon::parse($transactionDetail->transaction_info->transaction_initiation_date)
            ->setTimezone('Europe/Vienna');
    }
}
