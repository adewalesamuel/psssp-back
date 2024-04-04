<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Account;
use App\Models\Product;
use App\Models\AccountSponsor;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Jobs\NotificationJob;
use App\Models\SubscriptionPlan;
use App\Notifications\AccountSponsorNotification;
use App\Utils;
use Illuminate\Support\Facades\DB;
use App\Psssp;

class ApiUserAuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only("email", "password");

        if (!Auth::guard()->once($credentials)) {
            $data = [
                'error' => true,
                'message' => "Login ou mot de passe incorrect"
            ];

            return response()->json($data, 404);
        }

        $account = Account::where('email', $credentials['email'])
        ->with(['user', 'user.subscription_plan'])->first();

        $data = [
            'success' => true,
            'account' => $account,
            'tk' => $account->api_token
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

            $account_count = $user->accounts()->count();

            if ($account_count < 11) {
                $subscription_plan = SubscriptionPlan::where('slug', 'plan-super-simple')->first();
                $user->subscription_plan_id = $subscription_plan->id;
                $user->save();
            }

            $sponsor = $this->_assign_sponsor_to_account(
                $account, $validated['referer_sponsor_code']);

            $sponsor_account = Account::where('user_id', $sponsor->id)
            ->latest()->firstOrFail();

            NotificationJob::dispatchAfterResponse(
                $sponsor_account,
                new AccountSponsorNotification($account));

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }

        $user->subscription_plan;

        $account['user'] = $user;

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

    private function _assign_sponsor_to_account(
        Account $account,
        $referer_sponsor_code): User {

        if (isset($referer_sponsor_code) &&
            User::where('sponsor_code', $referer_sponsor_code)->exists()) {
            $sponsor = User::where('sponsor_code',
                $referer_sponsor_code)->firstOrFail();

            //TODO: check if latest sponsor account has books else assign solidarite

            $sponsor->increment('num_code_use');
            $sponsor->save();

            //TODO: loop through max account number by subscription plan and get array range for solidarite assign
            if (in_array($sponsor->num_code_use, [4, 6]))
                $sponsor = Psssp::getSolidariteUser();

        } else {
            $sponsor = Psssp::getSolidariteUser();
        }

        $account_sponsor = new AccountSponsor;

        $account_sponsor->user_id = $sponsor->id;
        $account_sponsor->account_id = $account->id;

        $account_sponsor->save();

        return $sponsor;
    }

}
