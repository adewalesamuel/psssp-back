<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\account;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Utils;
use Illuminate\Support\Facades\DB;

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

        $account = Account::where('email', $credentials['email'])->first();

        $data = [
            "success" => true,
            "account" => $account,
            "tk" => $account->api_token
        ];

        return response()->json($data);
    }

    public function register(StoreAccountRequest $request) {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $user = User::where('phone_number', $validated['phone_number'])->first();

            if (!$user) {
                $user = new User;
                $user->phone_number = $validated['phone_number'] ?? null;
                $user->sponsor_code = "CP" . Utils::generateRandAlnum();

                $user->save();
            }

            $token =  Str::random(60);

            $account = new Account;

            $account->fullname = $validated['fullname'] ?? null;
            $account->email = $validated['email'] ?? null;
            $account->password = $validated['password'] ?? null;
            $account->backup_number = $validated['backup_number'] ?? null;
            $account->whatsapp_number = $validated['whatsapp_number'] ?? null;
            $account->telegram_number = $validated['telegram_number'] ?? null;
            $account->shop_name = $validated['shop_name'] ?? null;
            $account->profile_img_url = $validated['profile_img_url'] ?? null;
            $account->is_active = false;
            $account->referer_sponsor_code = $validated['referer_sponsor_code'] ?? null;
            $account->activation_code = "CA" . Utils::generateRandAlnum();
            $account->country_id = $validated['country_id'] ?? null;
            $account->api_token = $token;
            $account->user_id = $user->id;

            $account->save();

            if (isset($validated['referer_sponsor_code'])) {
                $sponsor = Account::where('sponsor_code', 
                    $validated['referer_sponsor_code'])->first();

                $sponsor->num_code_use->increment();
                $sponsor->save();
            } else {
                //Chose random user
            }

            //Send activation code push notif

            DB::commit();
        } catch(\Exception $e) {
            Db::rollback();
            throw new \Exception($e);
        }

        
        $data = [
            'success'  => true,
            'account'   => $account,
            'tk' => $token
        ];

        return response()->json($data);
    }

    public function logout(Request $request) {
        $token = explode(" ", $request->header('Authorization'))[1];
        $account = Account::where('api_token', $token)->firstOrFail();

        $account->api_token = Str::random(60);

        $account->save();

        $data = [
            "success" => true,
        ];

        return response()->json($data, 200);
    }

}
