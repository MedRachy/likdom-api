<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nexmo\Laravel\Facade\Nexmo;


class VerifyMobileController extends Controller
{
    public function send_code($phone)
    {
        if ($phone) {
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

    public function verify_phone(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'request_id' => 'required',
            'code' => ['required', 'string', 'size:4']
        ]);

        try {
            $result =  Nexmo::verify()->check($request->request_id, $request->code);
            // A status value of 0 indicates that your user entered the correct code. 
            if ($result['status'] == "0") {
                return  response()->json(['success' => 'phone verified ' . $result["status"]], 200);
            }
        } catch (Exception $e) {
            return  response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update_and_verify_phone(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'request_id' => 'required',
            'code' => ['required', 'string', 'size:4']
        ]);

        try {
            $result =  Nexmo::verify()->check($request->request_id, $request->code);
            // A status value of 0 indicates that your user entered the correct code. 
            if ($result['status'] == "0") {
                $user = User::find(Auth::id());
                $user->update([
                    'phone_verified' => true,
                    'phone' => $request->phone
                ]);
                return  response()->json(['success' => 'phone updated ' . $result["status"]], 200);
            }
        } catch (Exception $e) {
            return  response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
