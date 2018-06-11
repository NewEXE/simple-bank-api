<?php

namespace Tests\Feature\Feature\Api\Auth;

use App\Models\User;
use Tests\TestCase;

/**
 * Class LoginTest
 * @package Tests\Feature\Feature
 */
class LoginTest extends TestCase
{
    /**
     * @return void
     */
    public function testRequiresNameAndCnp()
    {
        $this->json('POST', route('api.user.login'))
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors'
            ]);
    }

    /**
     * @return void
     */
    public function testUserLoginsSuccessfully()
    {
        factory(User::class)->create($this->credentials);

        $this->json('POST', route('api.user.login'), $this->credentials)
            ->assertStatus(200)
            ->assertJsonStructure([
                'api_token'
            ]);
    }
}
