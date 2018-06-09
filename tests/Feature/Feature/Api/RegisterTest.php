<?php

namespace Tests\Feature\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class RegisterTest
 * @package Tests\Feature\Feature
 */
class RegisterTest extends TestCase
{
    /**
     * @return void
     */
    public function testRequiresNameAndCnp()
    {
        $this->json('POST', route('api.user.register'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);
    }

    /**
     * @return void
     */
    public function testRegistersSuccessfully()
    {
        $this->json('POST', route('api.user.register'), $this->credentials)
            ->assertStatus(201); //todo assertJsonCount
    }
}
