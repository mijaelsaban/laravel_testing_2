<?php

use Database\Seeders\TransactionEventCodesSeeder;
use Database\Seeders\TransactionProviderSeeder;
use Database\Seeders\TransactionTypeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         $this->call(TransactionProviderSeeder::class);
         $this->call(TransactionEventCodesSeeder::class);
         $this->call(TransactionTypeSeeder::class);
    }
}
