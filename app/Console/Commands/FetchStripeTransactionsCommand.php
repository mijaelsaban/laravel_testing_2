<?php

namespace App\Console\Commands;

use Log;
use Artisan;
use Carbon\Carbon;
use App\Models\UserDetail;
use Illuminate\Console\Command;
use App\Services\Transactions\Stripe\FetchService;

/**
 * Class FetchStripeTransactions
 * @package App\Console\Commands
 */
class FetchStripeTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:fetchStripe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Match transactions to orders';

    public function handle(FetchService $fetchService): void
    {
        try {
            $this->fetchTransactions($fetchService);
        } catch (\Exception $e) {
            Log::error(sprintf(
                "[%s: %s %s]",
                __CLASS__,
                $e->getMessage(),
                $e->getTraceAsString()
            ));
        }

        Artisan::call('transactions:matchOrders');
        Artisan::call('transactions:matchRefunds');
        Log::info('Import finished ');
    }

    /**
     * @param FetchService $fetchService
     * @return void
     */
    private function fetchTransactions(FetchService $fetchService): void
    {
        $dateFrom = $this->getDateFrom();
        $dateTo = $this->getDateTo();
        /**
         * @var UserDetail $lastTransaction
         */
        $fetchService->handle($dateFrom, $dateTo);
    }

    /**
     * @return int
     */
    protected function getDateFrom(): int
    {
        return Carbon::now()->subHours(6)->unix();
    }

    /**
     * @return int
     */
    protected function getDateTo(): int
    {
        return Carbon::now()->unix();
    }
}
