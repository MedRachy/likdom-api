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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Nexmo\Laravel\Facade\Nexmo;
use App\Actions\Fortify\PasswordValidationRules;
use Exception;

class UsersController extends Controller
{
    use PasswordValidationRules;

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

    public function password_check(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (Hash::check($request->password, Auth::user()->password)) {
            return  response()->json(['message' => 'password correct'], 200);
        } else {
            return  response()->json(['message' => 'wrong password'], 422);
        }
    }

    public function send_reset_code($phone)
    {
        if ($phone) {

            $user = User::firstWhere('phone', $phone);
            if (!$user) {
                return  response()->json(['message' => "no user found with this phone number"], 422);
            }
            try {
                // send code
                // TODO : test number phone formating
                // test workflow_id : https://developer.vonage.com/en/verify/guides/workflows-and-events
                // pin_expiry : default to : 300 seconds
                $response = Nexmo::verify()->start([
                    'from' => 'LIKDOM',
                    'number' => $phone,
                    'brand'  => 'LIKDOM',
                    'lg' => 'fr-fr',
                    'country' => 'MA',
                    'workflow_id' => 6
                ]);
                return  response()->json(['request_id' => $response->getRequestId()], 200);
            } catch (Exception $e) {
                return  response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            return  response()->json(['message' => 'unvalid phone number'], 422);
        }
    }

    public function verify_reset_password(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'request_id' => 'required',
            'code' => ['required', 'string', 'size:4'],
            'password' => $this->passwordRules(),
        ]);

        $user = User::firstWhere('phone', $request->phone);
        if (!$user) {
            return  response()->json(['message' => "no user found with this phone number"], 422);
        }

        try {
            $result =  Nexmo::verify()->check($request->request_id, $request->code);
            // A status value of 0 indicates that your user entered the correct code. 
            if ($result['status'] == "0") {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
                $user->tokens()->delete();
                return  response()->json(['message' => 'reset password successful' . $result["status"]], 200);
            }
        } catch (Exception $e) {
            return  response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(DeletesUsers $deleter)
    {
        // $user = User::find(Auth::id());

        $deleter->delete(Auth::user()->fresh());
    }
}
