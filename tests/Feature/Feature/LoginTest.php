<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * @return void
     */
    public function testRequiresNameAndCnp()
    {
        $this->json('POST', route('api.user.login'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);
    }

    /**
     * @return void
     */
    public function testUserLoginsSuccessfully()
    {
        $name = str_random();
        $cnp = str_random(60);

        $credentials = compact('name', 'cnp');

        $user = factory(User::class)->create($credentials);

        $this->json('POST', route('api.user.login'), $credentials)
            ->assertStatus(200)
            ->assertJsonStructure([
                'api_token'
            ]);
    }
}
