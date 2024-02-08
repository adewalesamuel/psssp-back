<?php
namespace App\Http\Controllers;

use App\Http\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Utils;
use Illuminate\Support\Str;


class ProductController extends Controller
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
            'products' => Product::where('id', '>', -1)
            ->with(['category'])->orderBy('created_at', 'desc')->paginate()
        ];

        return response()->json($data);
    }

    public function user_index(Request $request)
    {
        $user = Auth::getUser($request, Auth::USER);

        $data = [
            'success' => true,
            'products' => Product::where('user_id', $user->id)
            ->with(['category'])->orderBy('created_at', 'desc')->paginate()
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
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = new Product;

        $product->name = $validated['name'] ?? null;
		$product->slug = Str::slug($validated['name']) . Str::random(6);
		$product->description = $validated['description'] ?? null;
		$product->price = $validated['price'] ?? null;
		$product->download_code = "CP" . Utils::generateRandAlnum();
		$product->initial_stock = $validated['initial_stock'] ?? null;
		$product->current_stock = $validated['current_stock'] ?? null;
		$product->img_url = $validated['img_url'] ?? null;
		$product->file_url = $validated['file_url'] ?? null;
		$product->user_id = $validated['user_id'] ?? null;
		$product->category_id = $validated['category_id'] ?? null;

        $product->save();

        $data = [
            'success'       => true,
            'product'   => $product
        ];

        return response()->json($data);
    }

    public function user_store(StoreProductRequest $request)
    {
        $user = Auth::getUser($request, Auth::USER);
        $validated = $request->validated();

        $product = new Product;

        $product->name = $validated['name'] ?? null;
		$product->slug = Str::slug($validated['name']) . Str::random(6);
		$product->description = $validated['description'] ?? null;
		$product->price = $validated['price'] ?? null;
		$product->download_code = "CP" . Utils::generateRandAlnum();
		$product->initial_stock = $validated['initial_stock'] ?? null;
		$product->current_stock = $validated['current_stock'] ?? null;
		$product->img_url = $validated['img_url'] ?? null;
		$product->file_url = $validated['file_url'] ?? null;
		$product->user_id = $user->id;
		$product->category_id = $validated['category_id'] ?? null;

        $product->save();

        $data = [
            'success'       => true,
            'product'   => $product
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = [
            'success' => true,
            'product' => $product
        ];

        return response()->json($data);
    }

    public function user_show(Request $request, string $slug)
    {
        $user = Auth::getUser($request, Auth::USER);

        $data = [
            'success' => true,
            'product' => Product::where('user_id', $user->id)
            ->where('slug', $slug)->firstOrFail()
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->name = $validated['name'] ?? null;
		$product->description = $validated['description'] ?? null;
		$product->price = $validated['price'] ?? null;
		$product->download_code = "CP" . Utils::generateRandAlnum();
		$product->initial_stock = $validated['initial_stock'] ?? null;
		$product->current_stock = $validated['current_stock'] ?? null;
		$product->img_url = $validated['img_url'] ?? null;
		$product->file_url = $validated['file_url'] ?? null;
		$product->user_id = $validated['user_id'] ?? null;
		$product->category_id = $validated['category_id'] ?? null;

        $product->save();

        $data = [
            'success'       => true,
            'product'   => $product
        ];

        return response()->json($data);
    }

    public function user_update(UpdateProductRequest $request, Product $product)
    {
        $user = Auth::getUser($request, Auth::USER);
        $validated = $request->validated();

        $product->name = $validated['name'] ?? null;
		$product->description = $validated['description'] ?? null;
		$product->price = $validated['price'] ?? null;
		$product->initial_stock = $validated['initial_stock'] ?? null;
		$product->current_stock = $validated['current_stock'] ?? null;
		$product->img_url = $validated['img_url'] ?? null;
		$product->file_url = $validated['file_url'] ?? null;
		$product->user_id = $user->id;
		$product->category_id = $validated['category_id'] ?? null;

        $product->save();

        $data = [
            'success'       => true,
            'product'   => $product
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        $data = [
            'success' => true,
            'product' => $product
        ];

        return response()->json($data);
    }
}
