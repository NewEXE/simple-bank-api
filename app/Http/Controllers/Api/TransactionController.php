<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\TransactionFilters;
use App\Http\Requests\Api\Transaction\TransactionDestroyRequest;
use App\Http\Requests\Api\Transaction\TransactionIndexRequest;
use App\Http\Requests\Api\Transaction\TransactionShowRequest;
use App\Http\Requests\Api\Transaction\TransactionStoreRequest;
use App\Http\Requests\Api\Transaction\TransactionUpdateRequest;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    use TransactionFilters;

    /**
     * Display a listing of the resource.
     *
     * @param TransactionIndexRequest $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(TransactionIndexRequest $request)
    {
        $transactions = $this->getTransactionsByFilters($request)->get();

        return $transactions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionStoreRequest $request)
    {
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
     * @param TransactionShowRequest $request
     * @param User $user
     * @param  \App\Models\Transaction $transaction
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show(TransactionShowRequest $request, User $user, Transaction $transaction)
    {
        $transaction = $user->transactions()->findOrFail($transaction->id);

        $transactionData = [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->user->id,
            'amount' => $transaction->amount,
            'date' => $transaction->date,
        ];

        return response()->json($transactionData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransactionUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionUpdateRequest $request)
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
     * @param TransactionDestroyRequest $request
     * @param  \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TransactionDestroyRequest $request, Transaction $transaction)
    {
        $result = $transaction->delete();

        return response()->json((bool) $result, 204);
    }
}
