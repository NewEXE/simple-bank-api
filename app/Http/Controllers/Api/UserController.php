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
