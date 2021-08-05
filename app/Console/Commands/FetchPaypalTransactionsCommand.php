<?php

namespace App\Console\Commands;

use Artisan;
use Carbon\Carbon;
use JsonException;
use Illuminate\Console\Command;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use App\Services\Transactions\Paypal\FetchService;
use App\Services\Transactions\Paypal\CreateService;

/**
 * Class FetchPaypalTransactions
 * @package App\Console\Commands
 */
class FetchPaypalTransactionsCommand extends Command
{
    public const PAGE_SIZE = 500;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:fetchPaypal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Match transactions to orders';


    /**
     * @throws JsonException
     */
    public function handle(
        PayPalHttpClient $payPalHttpClient,
        CreateService $createService,
        FetchService $fetchService
    ): void {
        $fetchService->handle($payPalHttpClient, $createService, $this->getStartDate(), $this->getEndDate());
        Artisan::call('transactions:matchOrders');
        Artisan::call('transactions:matchRefunds');
    }

    private function getStartDate(): string
    {
        return Carbon::now()->subHours(6)->toIso8601String();
    }

    private function getEndDate(): string
    {
        return Carbon::now()->toIso8601String();
    }
}
