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
        /**
         * Valid data
         */
        $expectedUsers =  User::factory()->active()
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

        $content = collect(json_decode($response->getContent()));

        $this->assertEquals(
            $expectedUsers->pluck('email'),
            $content->pluck('email')
        );

        $this->assertEquals(
            7,
            $content->count()
        );
    }

    /**
     * @test
     */
    public function itCannotUpdateUserDetailsWhenDoesntExist()
    {
        /**
         * Invalid data
         */
        $user = User::factory()->create();

        $this->putJson('api/users/' . $user->id)
            ->assertStatus(500);
    }


    /**
     * @test
     */
    public function itCanUpdateUserDetailsWhenExist()
    {
        $this->withoutExceptionHandling();
        /**
         * Valid data
         */
        $user = User::factory()->active()
            ->has(UserDetail::factory())
            ->create();

        $response = $this->putJson(
            'api/users/' . $user->id,
            [
                 'citizenship_country_id' => 1,
                 'first_name' => 'Carlos',
                 'last_name' => 'Bar',
                 'phone_number' => 123456,
            ]
        )
            ->assertStatus(200);

        $result = (array)json_decode($response->getContent())->updated->user_detail;

        $this->assertEquals([
            'citizenship_country_id' => 1,
            'first_name' => 'Carlos',
            'last_name' => 'Bar',
            'phone_number' => 123456,
            'id' => $user->userDetail->id,
            'user_id' => $user->id
        ], $result);
    }

    /**
     * @test
     */
    public function itCanDeleteUserWhenNoUserDetails()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->active()
            ->create();

        $response = $this->deleteJson(
            'api/users/' . $user->id
        )
            ->assertStatus(200);
    }


    /**
     * @test
     */
    public function itCannotDeleteUserHasUserDetails()
    {
        $user = User::factory()->active()
            ->has(UserDetail::factory())
            ->create();

        $response = $this->deleteJson(
            'api/users/' . $user->id
        )
            ->assertStatus(500);
    }
}
