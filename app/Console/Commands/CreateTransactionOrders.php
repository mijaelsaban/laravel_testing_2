<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TransactionOrders\CreateService;

class CreateTransactionOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:matchOrders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Match transactions to orders';


    public function handle(CreateService $createService): void
    {
        $createService->handle();
    }
}
