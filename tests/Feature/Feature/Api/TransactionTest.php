<?php

namespace Tests\Feature\Feature\Api;

use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Class TransactionTest
 * @package Tests\Feature\Feature
 */
class TransactionTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     */
    public function testTransactionsAreListedCorrectly()
    {
        $user = factory(User::class)->create();

        factory(Transaction::class)->create(['user_id'=>$user->id]);
        factory(Transaction::class)->create(['user_id'=>$user->id]);

        $transactionsCount = Transaction::count();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', route('api.transactions.index'), [], $headers)
            ->assertStatus(200)
            ->assertJsonCount($transactionsCount)
            ->assertJsonStructure([
                '*' => ['id', 'date', 'amount', 'created_at', 'updated_at', 'user_id'],
            ]);
    }

    /**
     * @return void
     */
    public function testTransactionAreCreatedCorrectly()
    {
        $user = factory(User::class)->create($this->credentials);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $customerId = $user->id;
        $amount = $this->faker->randomFloat(2, 1, 255);
        $date = '';

        $payload = compact('customerId', 'amount', 'date');

        $this->json('POST', route('api.transactions.store'), $payload, $headers)
            ->assertStatus(201)
            ->assertJsonStructure(['transactionId', 'customerId', 'amount', 'date'])
            ->assertJson(['customerId' => $user->id, 'amount' => $amount]);
    }

    /**
     * @return void
     */
    public function testTransactionAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $amount = $this->faker->randomFloat(2, 1, 255);
        $date = '';

        $transaction = $user->transactions()->create([
            'amount' => $amount,
            'date' => $date,
        ]);

        $newAmount = $this->faker->randomFloat(2, 1, 255);

        $dataForTransactionUpdating = [
            'transactionId' => $transaction->id,
            'amount' => $newAmount,
        ];

        $this->json('PUT', route('api.transactions.update'), $dataForTransactionUpdating, $headers)
            ->assertStatus(200)
            ->assertJson([
                'transactionId' => $transaction->id,
                'customerId' => $user->id,
                'amount' => $newAmount,
            ]);
    }

    /**
     * @return void
     */
    public function testsTransactionAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $amount = $this->faker->randomFloat(2, 1, 255);
        $date = '';

        $transaction = $user->transactions()->create([
            'amount' => $amount,
            'date' => $date,
        ]);

        $this->json(
            'DELETE',
            route('api.transactions.destroy', ['transactionId'=>$transaction->id]),
            [],
            $headers)
            ->assertStatus(204);

        $deletedTransaction = Transaction::find($transaction->id);

        $this->assertEquals(null, $deletedTransaction);
    }
}
