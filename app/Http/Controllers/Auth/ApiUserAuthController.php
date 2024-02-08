<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Utils;

class ApiUserAuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only("email", "password");

        if (!Auth::guard()->once($credentials)) {
            $data = [
                'error' => true,
                'message' => "Mail ou mot de passe incorrect"
            ];

            return response()->json($data, 404);
        }

        $user = User::where('email', $credentials['email'])->first();

        $data = [
            "success" => true,
            "user" => $user,
            "tk" => $user->api_token
        ];

        return response()->json($data);
    }

    public function register(StoreUserRequest $request) {
        $validated = $request->validated();

        $user = new User;
        $token =  Str::random(60);

        $user->fullname = $validated['fullname'] ?? null;
		$user->email = $validated['email'] ?? null;
		$user->password = $validated['password'] ?? null;
		$user->phone_number = $validated['phone_number'] ?? null;
		$user->backup_number = $validated['backup_number'] ?? null;
		$user->whatsapp_number = $validated['whatsapp_number'] ?? null;
		$user->telegram_number = $validated['telegram_number'] ?? null;
		$user->shop_name = $validated['shop_name'] ?? null;
		$user->profile_img_url = $validated['profile_img_url'] ?? null;
        $user->is_active = false;
		$user->sponsor_code = "CP" . Utils::generateRandAlnum();
        $user->referer_sponsor_code = $validated['referer_sponsor_code'] ?? null;
		$user->activation_code = "CA" . Utils::generateRandAlnum();
		$user->country_id = $validated['country_id'] ?? null;
		$user->api_token = $token;

        $user->save();

        // AdminMailNotificationJob::dispatchAfterResponse(
        //     new UserRegisterNotification($user));

        $data = [
            'success'  => true,
            'user'   => $user,
            'tk' => $token
        ];

        return response()->json($data);
    }

    public function logout(Request $request) {
        $token = explode(" ", $request->header('Authorization'))[1];
        $user = User::where('api_token', $token)->firstOrFail();

        $user->api_token = Str::random(60);

        $user->save();

        $data = [
            "success" => true,
        ];

        return response()->json($data, 200);
    }

}
