<?php

namespace App\Http\Controllers;

use App\Http\Auth;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\AccountValidateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Utils;

class AccountController extends Controller
{
  public function index()
    {
        $data = [
            'success' => true,
            'accounts' => Account::with(['country', 'user'])
            ->orderBy('created_at', 'desc')->paginate()
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        $validated = $request->validated();

        $account = new Account;

        $account->fullname = $validated['fullname'] ?? null;
        $account->email = $validated['email'] ?? null;
        $account->password = $validated['password'] ?? null;
        $account->backup_number = $validated['backup_number'] ?? null;
        $account->whatsapp_number = $validated['whatsapp_number'] ?? null;
        $account->telegram_number = $validated['telegram_number'] ?? null;
        $account->shop_name = $validated['shop_name'] ?? null;
        $account->profile_img_url = $validated['profile_img_url'] ?? null;
        $account->referer_sponsor_code = $validated['referer_sponsor_code'] ?? null;
        $account->country_id = $validated['country_id'] ?? null;
        $account->user_id = $validated['user_id'] ?? null;
        $account->api_token = Str::random(60);

        $account->save();

        $data = [
            'success'       => true,
            'account'   => $account
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        $data = [
            'success' => true,
            'account' => $account
        ];

        return response()->json($data);
    }

    public function account_analytics(Request $request) {
        $account = Auth::User($request, Auth::ACCOUNT);

        $account_product_id_list = Product::where('account_id', $account->id)
        ->pluck('id')->toArray();
        $account_product_order_list = Order::whereIn('product_id', $account_product_id_list);
        $account_product_list = Product::whereIn('id', $account_product_id_list);

        $data = [
            'success' => true,
            'analytics' => [
                'products_count' => count($account_product_id_list),
                '
                ' => $account_product_order_list->groupBy('account_id')->count(),
                'revenu' => $account_product_order_list->sum('amount'),
                'orders_count' => $account_product_order_list->count(),
                'initial_stock' => $account_product_list->sum('initial_stock'),
                'current_stock' => $account_product_list->sum('current_stock'),
                'notifications_count' => $account->notifications->count()
            ]
        ];

        return response()->json($data, 200);
    }

    public function account_show(Request $request)
    {
        $account = Auth::User($request, Auth::ACCOUNT);

        $data = [
            'success' => true,
            'account' => $account
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $validated = $request->validated();

        $account->fullname = $validated['fullname'] ?? null;
        $account->email = $validated['email'] ?? null;
        $account->password = $validated['password'] ?? null;
        $account->backup_number = $validated['backup_number'] ?? null;
        $account->whatsapp_number = $validated['whatsapp_number'] ?? null;
        $account->telegram_number = $validated['telegram_number'] ?? null;
        $account->shop_name = $validated['shop_name'] ?? null;
        $account->profile_img_url = $validated['profile_img_url'] ?? null;
        $account->referer_sponsor_code = $validated['referer_sponsor_code'] ?? null;
        $account->country_id = $validated['country_id'] ?? null;
        $account->user_id = $validated['user_id'] ?? null;

        $account->save();

        $data = [
            'success'       => true,
            'account'   => $account
        ];

        return response()->json($data);
    }

    public function account_update(UpdateAccountRequest $request)
    {
        $account = Auth::User($request, Auth::ACCOUNT);
        $validated = $request->validated();

        $account->fullname = $validated['fullname'] ?? null;
        $account->email = $validated['email'] ?? null;
        $account->password = $validated['password'] ?? null;
        $account->backup_number = $validated['backup_number'] ?? null;
        $account->whatsapp_number = $validated['whatsapp_number'] ?? null;
        $account->telegram_number = $validated['telegram_number'] ?? null;
        $account->shop_name = $validated['shop_name'] ?? null;
        $account->profile_img_url = $validated['profile_img_url'] ?? null;
        $account->referer_sponsor_code = $validated['referer_sponsor_code'] ?? null;
        $account->country_id = $validated['country_id'] ?? null;

        $account->save();

        $data = [
            'success'       => true,
            'account'   => $account
        ];

        return response()->json($data);
    }

    public function account_password(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::getUser($request, Auth::ACCOUNT);

        $user->password = $validated['passowrd'];

        $user->save();

        $data = [
            'success' => true,
        ];

        return response()->json($data, 200);
    }


    public function account_validate(AccountValidateRequest $request) {
        $validated = $request->validated();
        $account = Auth::User($request, Auth::ACCOUNT);

        if ($account->activation_code != $validated['activation_code']) {
            $data = [
                'error' => true,
                'message' => 'Code de validation incorrect'
            ];

            return response()->json($data, 400);
        }

        $account->is_active = true;

        $account->save();

        $data = [
            'success' => true,
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();

        $data = [
            'success' => true,
            'user' => $account
        ];

        return response()->json($data);
    }
}
