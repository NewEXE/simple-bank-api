<?php
/**
 * Created by PhpStorm.
 * User: newexe
 * Date: 04.06.18
 * Time: 17:20
 */

namespace App\Services;

use App\Models\User;
use Ixudra\Curl\Facades\Curl;

/**
 * Class InternalApi
 * @package App\Services
 */
class InternalApi
{
    /**
     * @var string|null
     */
    protected $apiToken = null;

    /**
     * InternalApi constructor.
     *
     * @param User $user
     * @throws \Exception
     */
    public function __construct($user)
    {
        $token = $this->login($user->name, $user->cnp);

        if (! $token) throw new \Exception('Invalid credentials for API login');

        $this->apiToken = $token;
    }

    /**
     * @return array Transactions list
     */
    public function getAllTransactions()
    {
        $response = Curl::to(route('api.transactions.index'))
            ->asJson()
            ->withHeaders(['Accept: application/json'])
            ->withData([
                'api_token' => $this->apiToken
            ])
            ->get();

        if (! $response || ! empty($response->errors)) $response = [];

        return $response;
    }

    /**
     * @param $name
     * @param $cnp
     * @return int|false Customer's ID or false
     */
    public function addCustomer($name, $cnp)
    {
        $response = Curl::to(route('api.user.register'))
            ->asJson()
            ->withHeaders(['Accept: application/json'])
            ->withData([
                'name' => $name,
                'cnp' => $cnp,
                'api_token' => $this->apiToken,
            ])
            ->post();

        if (! $response || ! empty($response->errors)) $response = false;

        return $response;
    }

    /**
     * @param $name
     * @param $cnp
     * @return string|false Api token or false
     */
    public function login($name, $cnp)
    {
        $response = Curl::to(route('api.user.login'))
            ->asJson()
            ->withHeaders(['Accept: application/json'])
            ->withData([
                'name' => $name,
                'cnp' => $cnp
            ])
            ->post();

        $response = ! empty($response->api_token) ? $response->api_token : false;

        return $response;
    }

}