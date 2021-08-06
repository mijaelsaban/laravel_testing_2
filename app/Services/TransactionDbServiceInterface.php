<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionDbServiceInterface implements TransactionServiceInterface
{
    public function getAll()
    {
        return Transaction::all();
    }
}
