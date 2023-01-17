<?php

namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
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

    public function update(Request $request)
    {
        // The hasAny method returns true if any of the specified values are present
        if ($request->hasAny(['name', 'email'])) {
            try {
                $updater = new UpdateUserProfileInformation;
                return $updater->update(Auth::user(), $request->toArray());
            } catch (ValidationException $ex) {
                return response()->json([
                    'message' => $ex->errors()
                ], 400);
            }
        } else {
            return response()->json(['message' => 'name and email are not present'], 400);
        }
    }

    public function destroy(DeletesUsers $deleter)
    {
        // $user = User::find(Auth::id());

        $deleter->delete(Auth::user()->fresh());
    }
}
