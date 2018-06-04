<?php
/**
 * Created by PhpStorm.
 * User: newexe
 * Date: 04.06.18
 * Time: 15:37
 */

namespace App\Http\Controllers\Api\Traits;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Trait TransactionFilters
 * @package App\Http\Controllers\Api\Traits
 */
trait TransactionFilters
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getTransactionsByFilters(Request $request) {

        $transactions = Transaction::query();

        if ($request->customerId) {
            $transactions->byUser($request->customerId);
        }

        if ($request->amount) {
            $transactions->byAmount($request->amount);
        }

        if ($request->date) {
            $transactions->byDate($request->date);
        }

        if ($request->limit) {
            $transactions->byLimit($request->limit);
        }

        if ($request->offset) {
            $transactions->byOffset($request->offset);
        }

        return $transactions;

    }
}