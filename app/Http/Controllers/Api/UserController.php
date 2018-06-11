<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\User\UserStoreRequest;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Store a newly created User in storage.
     *
     * @api {post} /api/register-user Create customer
     * @apiGroup Users
     * @apiName Create user
     * @apiVersion 0.9.9
     *
     * @apiParam {sting} name User name
     * @apiParam {cnp} cnp Card not present
     * @apiParamExample {json} Request-Example:
     *     {
     *       "name": "Test Name",
     *       "cnp":"aaa54122-2a84-2345-6745-742t3g1e425g",
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 201 Created
     *   {
     *       12
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Unauthorized
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $filteredRequest = $request->only(['name', 'cnp']);

        $user = User::create($filteredRequest);

        return response()->json($user->id, 201);
    }
}
