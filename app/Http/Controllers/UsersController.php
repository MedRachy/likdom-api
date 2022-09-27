<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\UpdateUserPassword;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{

    public function show()
    {
        return new UserResource(Auth::user());
    }

    public function update_password(Request $request)
    {
        try {
            $updater = new UpdateUserPassword;
            return $updater->update(Auth::user(), $request->toArray());
        } catch (ValidationException $ex) {
            return response()->json([
                'message' => $ex->errors()
            ], 400);
        }
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
