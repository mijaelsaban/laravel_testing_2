<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getTypes() as $type) {
            TransactionType::insertOrIgnore([
                'name' => $type
            ]);
        }
    }

    private function getTypes(): array
    {
        return [
            'charge',
            'refund',
            'dispute',
            'payout',
            'adjustment',
            'stripe_fee',
            'transfer',
            'fee'
        ];
    }
}
