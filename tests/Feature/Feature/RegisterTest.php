<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $name = str_random();
        $cnp = str_random(60);

        $credentials = compact('name', 'cnp');

        $this->json('POST', route('api.user.register'), $credentials)
            ->assertStatus(201);
    }
}
