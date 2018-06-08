<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\TransactionFilters;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    use TransactionFilters;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = $this->getTransactionsByFilters($request)->get();

        return $transactions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filteredRequest = $request->only(['​customerId,', 'amount']);

        $user = User::findOrFail($request->customerId);

        $transaction = $user->transactions()->create([
            'amount' => $request->amount,
            'date' => '',
        ]);

        $transactionData = [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->user_id,
            'amount' => $transaction->amount,
            'date' => $transaction->date,
        ];

        return response()->json($transactionData, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param  \App\Models\Transaction $transaction
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show(User $user, Transaction $transaction)
    {
        $transaction = $user->transactions()->findOrFail($transaction->id);

        $transactionData = [
            'transactionId' => $transaction->id,
            'amount' => $transaction->amount,
            'date' => $transaction->date,
        ];

        return response()->json($transactionData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transactionId);
        $transaction->amount = $request->amount;
        $transaction->date = Carbon::now()->format(Transaction::DATE_FORMAT_SET);
        $transaction->save();

        $transactionData = [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->user->id,
            'amount' => $transaction->amount,
            'date' => $transaction->date,
        ];

        return response()->json($transactionData, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Transaction $transaction)
    {
        $result = $transaction->delete();

        return response()->json((bool) $result, 204);
    }
}
