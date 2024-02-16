<?php
namespace App\Http\Controllers;

use App\Http\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserValidateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Utils;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'success' => true,
            'users' => User::with(['country'])
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
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User;

        $user->fullname = $validated['fullname'] ?? null;
		$user->email = $validated['email'] ?? null;
		$user->password = $validated['password'] ?? null;
		$user->phone_number = $validated['phone_number'] ?? null;
		$user->backup_number = $validated['backup_number'] ?? null;
		$user->whatsapp_number = $validated['whatsapp_number'] ?? null;
		$user->telegram_number = $validated['telegram_number'] ?? null;
		$user->shop_name = $validated['shop_name'] ?? null;
		$user->profile_img_url = $validated['profile_img_url'] ?? null;
		$user->is_active = $validated['is_active'] ?? false;
        $user->sponsor_code = "CP" . Utils::generateRandAlnum();
        $user->referer_sponsor_code = $validated['referer_sponsor_code'] ?? null;
        $user->activation_code = "CA" . Utils::generateRandAlnum();
		$user->country_id = $validated['country_id'] ?? null;

        $user->save();

        $data = [
            'success'       => true,
            'user'   => $user
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = [
            'success' => true,
            'user' => $user
        ];

        return response()->json($data);
    }

    public function user_analytics(Request $request) {
        $user = Auth::getUser($request, Auth::USER);

        $user_product_id_list = Product::where('user_id', $user->id)
        ->pluck('id')->toArray();
        $user_product_order_list = Order::whereIn('product_id', $user_product_id_list);
        $user_product_list = Product::whereIn('id', $user_product_id_list);

        $data = [
            'success' => true,
            'analytics' => [
                'products_count' => count($user_product_id_list),
                '
                ' => $user_product_order_list->groupBy('user_id')->count(),
                'revenu' => $user_product_order_list->sum('amount'),
                'orders_count' => $user_product_order_list->count(),
                'initial_stock' => $user_product_list->sum('initial_stock'),
                'current_stock' => $user_product_list->sum('current_stock'),
                'notifications_count' => $user->notifications->count()
            ]
        ];

        return response()->json($data, 200);
    }

    public function user_show(Request $request)
    {
        $user = Auth::getUser($request, Auth::USER);

        $data = [
            'success' => true,
            'user' => $user
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->fullname = $validated['fullname'] ?? null;
		$user->email = $validated['email'] ?? null;
		$user->password = $validated['password'] ?? null;
		$user->phone_number = $validated['phone_number'] ?? null;
		$user->backup_number = $validated['backup_number'] ?? null;
		$user->whatsapp_number = $validated['whatsapp_number'] ?? null;
		$user->telegram_number = $validated['telegram_number'] ?? null;
		$user->shop_name = $validated['shop_name'] ?? null;
		$user->profile_img_url = $validated['profile_img_url'] ?? null;
		$user->is_active = $validated['is_active'] ?? null;
		$user->sponsor_code = $validated['sponsor_code'] ?? null;
		$user->activation_code = $validated['activation_code'] ?? null;
		$user->country_id = $validated['country_id'] ?? null;

        $user->save();

        $data = [
            'success'       => true,
            'user'   => $user
        ];

        return response()->json($data);
    }

    public function user_update(UpdateUserRequest $request)
    {
        $user = Auth::getUser($request, Auth::USER);
        $validated = $request->validated();

        $user->fullname = $validated['fullname'] ?? null;
		$user->email = $validated['email'] ?? null;
		$user->phone_number = $validated['phone_number'] ?? null;
		$user->backup_number = $validated['backup_number'] ?? null;
		$user->whatsapp_number = $validated['whatsapp_number'] ?? null;
		$user->telegram_number = $validated['telegram_number'] ?? null;
		$user->shop_name = $validated['shop_name'] ?? null;
		$user->profile_img_url = $validated['profile_img_url'] ?? null;
		$user->country_id = $validated['country_id'] ?? null;

        $user->save();

        $data = [
            'success'       => true,
            'user'   => $user
        ];

        return response()->json($data);
    }

    public function user_password(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::getUser($request, Auth::USER);

        $user->password = $validated['passowrd'];

        $user->save();

        $data = [
            'success' => true,
        ];

        return response()->json($data, 200);

    }

    public function user_validate(UserValidateRequest $request) {
        $validated = $request->validated();
        $user = Auth::getUser($request, Auth::USER);

        if ($user->activation_code != $validated['activation_code']) {
            $data = [
                'error' => true,
                'message' => 'Code de validation incorrect'
            ];

            return response()->json($data, 400);
        }

        $user->is_active = true;

        $user->save();

        $referer = User::where('sponsor_code', $user->referer_sponsor_code)->first();
        $product = Product::where('download_code', $user->referer_sponsor_code)->first();

        $comunity_products = collect(Product::whereNull('user_id')
        ->orderBy('created_at', 'desc')->get())->map(function($product) use ($user) {
            unset($product['id']);
            unset($product['is_public']);
            unset($product['deleted_at']);
            unset($product['updated_at']);
            unset($product['created_at']);

            $product['user_id'] = $user->id;
            $product['slug'] .= Str::random(6);

            return $product;
        })->toArray();

        if ($referer) $product_list = Product::where('user_id', $referer->id);
        if ($product) $product_list = Product::where('id', $product->id);

        if (isset($product_list)) {
            $order_list = $product_list->get()->map(
                function($product) use($user) {
                    return [
                        'code' => Str::random(10),
                        'quantity' => 1,
                        'amount' => $product->price * 1,
                        'status' => 'validated',
                        'product_id' => $product->id,
                        'user_id' => $user->id
                    ];
                })->toArray();

            Order::insert($order_list);
        }

        Product::insert($comunity_products);

        $data = [
            'success' => true,
            'referer' => $referer,
            'product' => $product
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $data = [
            'success' => true,
            'user' => $user
        ];

        return response()->json($data);
    }
}
