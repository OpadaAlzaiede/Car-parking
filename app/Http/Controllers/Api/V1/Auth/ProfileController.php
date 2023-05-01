<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;

/**
 *  @group Auth
 */
class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user()->only('name', 'email'));
    }

    public function update(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->validated());

        return response()->json($request->validated(), Response::HTTP_ACCEPTED);
    }
}
