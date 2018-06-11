<?php

namespace Tests\Feature\Feature\Api\Auth;

use Tests\TestCase;

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
            ->assertJsonStructure([
                'message', 'errors'
            ]);
    }

    /**
     * @return void
     */
    public function testRegistersSuccessfully()
    {
        $response = $this->json('POST', route('api.user.register'), $this->credentials)
            ->assertStatus(201);

        $this->assertTrue(is_numeric($response->getContent()));
    }
}
