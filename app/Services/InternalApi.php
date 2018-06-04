<?php
/**
 * Created by PhpStorm.
 * User: newexe
 * Date: 04.06.18
 * Time: 17:20
 */

namespace App\Services;

use Ixudra\Curl\Facades\Curl;

/**
 * Class InternalApi
 * @package App\Services
 */
class InternalApi
{
    /**
     * @return mixed
     */
    public function getAllTransactions() {
        $response = Curl::to(route('api.transactions.index'))->get();
        $response = json_decode($response);

        return $response;
    }

    /**
     * @param $name
     * @param $cnp
     * @return mixed
     */
    public function addCustomer($name, $cnp) {
        $response = Curl::to(route('api.user.register'))
            ->withData([
                'name' => $name,
                'cnp' => $cnp
            ])
            ->post();

        return $response;
    }

    public function login($name, $cnp) {
        $response = Curl::to(route('api.user.register'))
            ->withData([
                'name' => $name,
                'cnp' => $cnp
            ])
            ->post();

        return $response;
    }

}