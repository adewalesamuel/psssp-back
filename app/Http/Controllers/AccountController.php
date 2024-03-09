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
use App\Models\Category;
use App\Models\AccountSponsor;
use Illuminate\Support\Str;
use App\Utils;
use Illuminate\Support\Facades\DB;

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
        $account = Auth::getUser($request, Auth::ACCOUNT);

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
        $account = Auth::getUser($request, Auth::ACCOUNT);

        $account->user;

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
        $account = Auth::getUser($request, Auth::ACCOUNT);
        $validated = $request->validated();

        $account->fullname = $validated['fullname'] ?? null;
        $account->email = $validated['email'] ?? null;
        $account->backup_number = $validated['backup_number'] ?? null;
        $account->whatsapp_number = $validated['whatsapp_number'] ?? null;
        $account->telegram_number = $validated['telegram_number'] ?? null;
        $account->shop_name = $validated['shop_name'] ?? null;
        $account->profile_img_url = $validated['profile_img_url'] ?? null;
        $account->referer_sponsor_code = $validated['referer_sponsor_code'] ?? 
        $account->referer_sponsor_code;
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
        $account = Auth::getUser($request, Auth::ACCOUNT);

        $account->password = $validated['passowrd'];

        $account->save();

        $data = [
            'success' => true,
        ];

        return response()->json($data, 200);
    }


    public function account_validate(AccountValidateRequest $request) {
        $validated = $request->validated();
        $account = Auth::getUser($request, Auth::ACCOUNT);

        if ($account->activation_code != $validated['activation_code']) {
            $data = [
                'error' => true,
                'message' => 'Code de validation incorrect'
            ];

            return response()->json($data, 400);
        }

        DB::beginTransaction();

        try {
            $account->is_active = true;

            $account->save();

            $ebook_category = Category::where('slug', 'like', '%ebook%')
            ->orWhere('slug', 'like', '%e-book%')->firstOrFail();

            $ebook_sub_category_id_list = collect(Category::where('category_id', 
                $ebook_category->id)->get())->map(function($sub_category) {
                return $sub_category->id;
            });

            $products = [
                Product::where('category_id', 
                    $ebook_sub_category_id_list[0])->firstOrFail(),
                Product::where('category_id', 
                    $ebook_sub_category_id_list[1])->firstOrFail(),
                Product::where('category_id', 
                    $ebook_sub_category_id_list[2])->firstOrFail(),
                Product::where('category_id', 
                    $ebook_sub_category_id_list[3])->firstOrFail(),
            ];

            //Create order

            // foreach ($products as $product) {
            //     $product->account_id = $account->id;

            //     $product->save();
            // }


            if ($account->referer_sponsor_code) {
                $account_sponsor = AccountSponsor::where('account_id', 
                $account->id)->firstOrFail();

                $sponsor_account = Account::where('user_id', 
                    $account_sponsor->user->id)->latest()->get();

                $product = Product::where('account_id', 
                    $sponsor_account->id)->firstOrFail();

                $product->delete();
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }

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
