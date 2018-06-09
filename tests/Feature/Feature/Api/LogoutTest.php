<?php

namespace Tests\Feature\Feature\Api;

use App\Models\User;
use Tests\TestCase;

/**
 * Class LogoutTest
 * @package Tests\Feature\Feature
 */
class LogoutTest extends TestCase
{
    /**
     * @return void
     */
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create($this->credentials);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', route('api.transactions.index'), [], $headers)->assertStatus(200);
        $this->json('POST', route('api.user.logout'), [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    /**
     * @return void
     */
    public function testUserWithNullToken()
    {
        // Simulating login
        $user = factory(User::class)->create($this->credentials);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Simulating logout
        $user->api_token = null;
        $user->save();

        $this->json('GET', route('api.transactions.index'), [], $headers)->assertStatus(401);
    }
}
