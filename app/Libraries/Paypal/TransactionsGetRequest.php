<?php

namespace App\Libraries\Paypal;

use PayPalHttp\HttpRequest;

/**
 * Class TransactionsGetRequest
 * @package App\Libraries\Paypal
 */
final class TransactionsGetRequest extends HttpRequest
{
    /**
     * TransactionsGetRequest constructor.
     * @param array $query
     */
    public function __construct(array $query)
    {
        parent::__construct(sprintf(
            "/v1/reporting/transactions?%s",
            http_build_query($query)
        ), "GET");
        $this->headers["Content-Type"] = "application/json";
    }
}
