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
use Illuminate\Validation\Rule;
use App\Actions\Fortify\PasswordValidationRules;
use App\Mail\WelcomeEmail;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    use PasswordValidationRules;

    public function show()
    {
        return new UserResource(Auth::user());
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
                ], 422);
            }
        } else {
            return response()->json(['message' => 'name and email are not present'], 422);
        }
    }

    public function update_phone(Request $request)
    {

        $user = User::find(Auth::id());

        $request->validate([
            'phone' => ['required', 'size:9', Rule::unique('users')->ignore($user->id)],
        ]);

        if ($user) {
            $user->update([
                'phone_verified' => true,
                'phone' => $request->phone
            ]);
            return  response()->json(['success' => 'phone updated '], 200);
        }
        return  response()->json(['message' => "no user found"], 404);
    }

    public function update_password(Request $request)
    {
        try {
            $updater = new UpdateUserPassword;
            return $updater->update(Auth::user(), $request->toArray());
        } catch (ValidationException $ex) {
            return response()->json([
                'message' => $ex->errors()
            ], 422);
        }
    }

    public function validate_phone(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'size:9', 'unique:users'],
        ]);

        return response()->json(['message' => 'phone validated'], 200);
    }

    public function phone_check(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'size:9', 'exists:users'],
        ]);

        return response()->json(['message' => 'phone exists'], 200);
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

    public function reset_password(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'size:9'],
            'password' => $this->passwordRules(),
        ]);

        $user = User::firstWhere('phone', $request->phone);
        if (!$user) {
            return  response()->json(['message' => "no user found with this phone number"], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        $user->tokens()->delete();
        return  response()->json(['message' => 'reset password successful'], 200);
    }

    public function destroy(DeletesUsers $deleter)
    {
        // $user = User::find(Auth::id());

        $deleter->delete(Auth::user()->fresh());
    }

    public function send_email(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        event(new Registered($user));
    }
}
