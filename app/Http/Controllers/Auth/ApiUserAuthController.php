<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\AdminMailNotificationJob;
use App\Notifications\UserRegisterNotification;
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
		$user->sponsor_code = "CP" . Utils::generateRandAlnum();
        $user->referer_sponsor_code = $validated['referer_sponsor_code'] ?? null;
		$user->activation_code = "CA" . Utils::generateRandAlnum();
		$user->country_id = $validated['country_id'] ?? null;

        $user->save();

        $referer = User::where('sponsor_code', $validated['referer_sponsor_code'])->first();
        $product = Product::where('download_code', $validated['referer_sponsor_code'])->first();

        // AdminMailNotificationJob::dispatchAfterResponse(
        //     new UserRegisterNotification($user));

        $data = [
            'success'  => true,
            'user'   => $user,
            'tk' => $token,
            'referer_id' => $referer ?? $referer->id,
            'producd_id' => $product ?? $product->id
        ];

        return response()->json($data);
    }

    // public function forgot_password(ForgotPasswordRequest $request) {
    //     $validated = $request->validated();
    //     $status = Password::sendResetLink($validated);

    //     $data = [
    //         'status' => __($status)
    //     ];

    //     return response()->json($data, 200);
    // }

    // public function reset_password(ResetPasswordRequest $request) {
    //     $validated = $request->validated();

    //     $status = Password::reset(
    //         $validated,
    //         function (User $user, string $password) {
    //             $user->password = $password;
    //             $user->save();

    //             event(new PasswordReset($user));
    //         }
    //     );

    //     $data = [
    //         'status' => __($status)
    //     ];

    //     return response()->json($data, 200);
    // }

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
