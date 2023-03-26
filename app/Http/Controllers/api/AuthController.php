<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;
use App\Http\Resources\UserResource;
use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Requests\StoreUserRequest;
use App\Mail\WelcomeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use PasswordValidationRules;

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'access-token'  => $user->createToken('access-token')->plainTextToken
        ];
    }

    public function validate_register(StoreUserRequest $request)
    {
        // The incoming form request is validated before the controller method is called
        // $validated_data = $request->validated();
        return response()->json(['message' => 'user validated'], 200);
    }

    public function register(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            // by default registration is after verification  
            'phone_verified' => true,
        ]);

        event(new Registered($user));

        return [
            'access-token' =>  $user->createToken('access-token')->plainTextToken,
            'user' => new UserResource($user)
        ];
    }

    public function logout()
    {
        // Revoke all tokens...
        // Auth()->user()->tokens()->delete();
        if (Auth::check()) {
            // Revoke the token that was used to authenticate the current request...
            Auth::user()->currentAccessToken()->delete();
            return  response()->json(['message' => 'user logout'], 200);
        } else {
            return  response()->json(['message' => 'Not authorized.'], 403);
        }
    }
}
