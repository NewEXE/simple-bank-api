<?php
/**
 * Created by PhpStorm.
 * User: newexe
 * Date: 11.06.18
 * Time: 19:16
 */

namespace App\Repositories\Api;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

/**
 * Class TransactionRepository
 * @package App\Repositories\Api
 */
class TransactionRepository extends BaseRepository
{
    /**
     * @return mixed|string
     */
    public function model()
    {
        return Transaction::class;
    }
}