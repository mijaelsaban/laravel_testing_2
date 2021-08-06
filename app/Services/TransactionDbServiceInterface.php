<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Collection;

class TransactionDbServiceInterface implements TransactionServiceInterface
{
    public function getAll(): Collection
    {
        return Transaction::all();
    }
}
