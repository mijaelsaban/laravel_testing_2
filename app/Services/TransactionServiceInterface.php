<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface TransactionServiceInterface
{
    public function getAll(): Collection;
}
