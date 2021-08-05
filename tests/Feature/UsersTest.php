<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Http\Controllers\UsersController
 */
class UsersTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function itReturnsUsersWhichAreActiveAndAreAustrians(): void
    {
        $this->withoutExceptionHandling();

        /**
         * Valid data
         */
        User::factory()->active()
            ->has(UserDetail::factory()->austrian())
            ->count(7)
            ->create();

        /**
         * Invalid data
         */
        User::factory()
            ->has(UserDetail::factory())
            ->count(5)
            ->create();

        $response = $this->get('api/users');

        $this->assertEquals(7, collect(json_decode($response->getContent()))->count());
    }
}
