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
     * Display a listing of the transactions.
     *
     * @api {get} /api/transactions?customerId=33&amount=9.99&date=yesterday&offset=2&limit=10 View Transactions list
     * @apiGroup Transaction
     * @apiName View a list of transactions
     * @apiDescription Returns transactions list
     * @apiVersion 0.9.9
     *
     * @apiParam {number} customerId Customer ID
     * @apiParam {string} api_token Customer API token
     * @apiParam {float} amount
     * @apiParam {date} date Format: all supported PHP date and time formats ( http://php.net/manual/en/datetime.formats.php )
     * @apiParam {number} offset
     * @apiParam {number} limit
     *
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *  [
     *      {
     *       "id":1,
     *       "date":"17.05.1984",
     *       "amount":"224.26",
     *       "created_at":"2018-06-04 15:24:48",
     *       "updated_at":"2018-06-04 15:24:48",
     *       "user_id": 1,
     *      },
     *      {
     *       "id":2,
     *       "date":"15.07.1998",
     *       "amount":"82.67",
     *       "created_at":"2018-06-04 15:24:48",
     *       "updated_at":"2018-06-04 15:24:48",
     *       "user_id": 1,
     *      }
     *  ]
     * @apiUse AuthHeader
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized customer
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
     * Store a newly created transaction in storage.
     *
     * @api {post} /api/transactions Create transaction
     * @apiGroup Transaction
     * @apiName Create Transaction
     * @apiVersion 0.9.9
     *
     * @apiParam {number} customerId customer ID
     * @apiParam {float} amount amount of transfer in format [0.99]
     * @apiParam {date} empty or in correct PHP date and time format
     * @apiParamExample {json} Request-Example:
     *     {
     *       "customerId": 11,
     *       "amount": "33.33",
     *       "date": "",
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 201 Created
     *   {
     *       "transactionId": 12,
     *       "customerId": 11,
     *       "amount": "33.33",
     *       "date": "20.03.2018",
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized customer
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
     * Display the specified transaction.
     *
     * @api {get} /api/transactions/:customerId/:transactionId View a Transaction
     * @apiGroup Transaction
     * @apiName View a Transaction
     * @apiDescription Returns Transaction info
     * @apiVersion 0.9.9
     *
     * @apiParam {number} customerId System Customer ID
     * @apiParam {number} transactionId System Transaction ID
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *     "transactionId": 2,
     *     "customerId": 1,
     *     "amount": "149.68",
     *     "date": "22.04.1982",
     *   }
     * @apiUse AuthHeader
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized customer
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
     * Update the specified transaction in storage.
     *
     * @api {put} /api/transactions Update transaction
     * @apiGroup Transaction
     * @apiName Update Transaction
     * @apiVersion 0.9.9
     *
     * @apiParam {number} transactionId ID
     * @apiParam {float} amount amount of transfer in format [0.99]
     * @apiParamExample {json} Request-Example:
     *     {
     *       "transactionId":3,
     *       "amount": "33.33",
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *       "transactionId": 3,
     *       "customerId": 11,
     *       "amount": "33.33",
     *       "date": "20.03.2018",
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized customer
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
     * Remove the specified transaction from storage.
     *
     * @api {delete} /api/transations/:transactionId Delete transaction
     * @apiGroup Transaction
     * @apiName Delete Transaction
     * @apiVersion 0.9.9
     *
     * @apiParam {number} transactionId ID
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 204 OK
     *   {
     *       true
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized customer
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
