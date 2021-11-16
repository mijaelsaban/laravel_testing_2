<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Http\Controllers\UsersController
 */
class TransactionsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function itRequiresValidation(): void
    {
        $response = $this->get('api/transactions');

        $this->assertEquals(
            422,
            $response->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function itAcceptsSourceDb()
    {
        $response = $this->get('api/transactions?source=db');

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function itAcceptsSourceCsv()
    {
        $response = $this->get('api/transactions?source=csv');

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function itFailsWhenOtherSource()
    {
        $response = $this->get('api/transactions?source=html');

        $this->assertEquals(
            422,
            $response->getStatusCode()
        );
    }
}
