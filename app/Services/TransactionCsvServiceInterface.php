<?php

namespace App\Services;

use League\Csv\Reader;
use League\Csv\Exception;
use Illuminate\Support\Collection;

class TransactionCsvServiceInterface implements TransactionServiceInterface
{
    /**
     * @throws Exception
     */
    public function getAll(): Collection
    {
        $csv = Reader::createFromPath(
            storage_path('app/transactions.csv'),
            'r'
        );

        $csv->setHeaderOffset(0);

        return collect($csv->getRecords());
    }
}
