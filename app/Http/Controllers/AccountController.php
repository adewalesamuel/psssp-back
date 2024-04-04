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
use App\Models\Ebook;
use App\Models\Category;
use App\Models\User;
use App\Models\AccountSponsor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Psssp;

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

    public function notification_index(Request $request) {
        $account = Auth::getUser($request, Auth::ACCOUNT);


        $data = [
            'success' => true,
            'notifications' => $account->notifications

        ];

        return response()->json($data, 200);
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

        $account_product_id_list = Product::where('account_id', $account->id);

        $account_product_id_list_with_trashed = Product::where(
            'account_id', $account->id)->withTrashed();

        $account_product_order_list = Order::whereIn('product_id',
        $account_product_id_list_with_trashed->pluck('id')->toArray());

        $account_product_list = Product::whereIn('id',
        $account_product_id_list->pluck('id')->toArray());

        $data = [
            'success' => true,
            'analytics' => [
                'accounts_count' => $account->user->accounts()->count(),
                'products_count' => $account_product_id_list->count(),
                'clients_count' => $account_product_order_list->groupBy('account_id')->count(),
                'revenu' => $account_product_order_list->sum('amount'),
                'orders_count' => $account_product_order_list->count(),
                'initial_stock' => intval($account_product_list->sum('initial_stock')),
                'current_stock' => intval($account_product_list->sum('current_stock')),
                'notifications_count' => count($account->notifications)
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
            'success'   => true,
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

            $product_list = $this->_get_unique_ebook_product_list();

            $order_list = [];

            foreach ($product_list as $product) {
                $order_list[] = [
                    'code' => strtoupper(Str::random(10)),
                    'quantity' => 1,
                    'amount' => $product->price ?? 0,
                    'status' => 'validated',
                    'product_id' => $product->id,
                    'account_id' => $account->id
                ];
            }

            Order::insert($order_list);

            //TODO: loop through suscription plan; check if plan[num_account] <= sponsor_account_num < plan+1[num_account]
            $this->_assign_product_list_to_account($account, 7);

            if (isset($account->referer_sponsor_code) &&
                User::where('sponsor_code', $account->referer_sponsor_code)->exists()) {
                $account_sponsor = AccountSponsor::where('account_id',
                $account->id)->firstOrFail();

                $sponsor_account = Account::where('user_id',
                    $account_sponsor->user->id)->latest()->firstOrFail();

                if (!Str::contains(Str::lower($sponsor_account->email), Psssp::SOLIDARITE_LOGIN)) {
                    $product = Product::where('account_id',
                        $sponsor_account->id)->firstOrFail();

                    $product->delete();
                }

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

    private function _get_unique_ebook_product_list() {
        $ebook_category = Category::where('slug', 'like', '%ebook%')
        ->orWhere('slug', 'like', '%e-book%')->firstOrFail();

        $product_list = collect(Category::where('category_id', $ebook_category->id)->get())
        ->map(function($sub_category) {
                return $this->_get_random_product_by_category_id($sub_category->id);
            }
        );

        return $product_list;
    }

    private function _assign_product_list_to_account(
        Account $account,
        int $product_max_num) {
            $ebook_id_list = Ebook::all()->pluck('id')->toArray();

            for ($i=0; $i < $product_max_num; $i++) {
                $random_index = rand(0, count($ebook_id_list) - 1);
                $random_ebook_id = $ebook_id_list[$random_index];

                $ebook = Ebook::findOrFail($random_ebook_id);

                $product = new Product;

                $product->name = $ebook->name ?? null;
                $product->slug = Str::slug($ebook->slug) . Str::random(6);
                $product->description = $ebook->description ?? null;
                $product->price = $ebook->price ?? null;
                $product->download_code = $ebook->download_code;
                $product->initial_stock = $ebook->initial_stock ?? null;
                $product->current_stock = $ebook->initial_stock ?? null;
                $product->img_url = $ebook->img_url ?? null;
                $product->file_url = $ebook->file_url ?? null;
                $product->account_id = $account->id ?? null;
                $product->category_id = $ebook->category_id ?? null;
                $product->is_public = $ebook->is_public ?? false;

                $product->save();

                array_splice($ebook_id_list, $random_index, 1);
            }
    }

    private function _get_random_product_by_category_id(int $category_id): Product {
        $product_id_list = Product::where('category_id', $category_id)
        ->withTrashed()->pluck('id')->toArray();

        $random_product_id = $product_id_list[rand(0, count($product_id_list) -1 )];

        $product = Product::where('id', $random_product_id)->firstOrFail();

        return $product;
    }
}
