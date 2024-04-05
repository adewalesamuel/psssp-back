<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Str;
use App\Http\Auth;
use \PDF;


class OrderController extends Controller
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
            'orders' => Order::with(['product', 'account'])
            ->orderBy('created_at', 'desc')->paginate()
        ];

        return response()->json($data);
    }

    public function account_index(Request $request) {
        $account =  Auth::getUser($request, Auth::ACCOUNT);
        $status = $request->input('status');
        $orders = Order::where('account_id', $account->id)
        ->with(['product', 'product.category', 'product.category.category']);

        if ($status) $orders = $orders->where('status', $status);

        $data = [
            'success' => true,
            'orders' => $orders->orderBy('created_at', 'desc')->get()
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
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        $order = new Order;

        $order->code = strtoupper(Str::random(10));
		$order->quantity = $validated['quantity'] ?? null;
		$order->amount = $validated['amount'] ?? null;
		$order->status = $validated['status'] ?? 'pending';
		$order->product_id = $validated['product_id'] ?? null;
		$order->account_id = $validated['account_id'] ?? null;

        $order->save();

        $data = [
            'success'       => true,
            'order'   => $order
        ];

        return response()->json($data);
    }

    public function account_store(StoreOrderRequest $request)
    {
        $account =  Auth::getUser($request, Auth::ACCOUNT);
        $validated = $request->validated();

        $order = new Order;

        $order->code = strtoupper(Str::random(10));
        $order->quantity = $validated['quantity'] ?? null;
        $order->amount = $validated['amount'] ?? null;
        $order->product_id = $validated['product_id'] ?? null;
        $order->account_id = $account->id;

        $order->save();

        $data = [
            'success'       => true,
            'order'   => $order
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $data = [
            'success' => true,
            'order' => $order
        ];

        return response()->json($data);
    }

    public function invoice(Request $request, Order $order) {
        $order['seller'] = $order->product->account;
        $order['buyer'] = $order->account;

        unset($order['account']);
        unset($order['product']);

        $data = [
            'order' => $order
        ];

        $pdf = PDF::loadView('invoice', $data);
        return $pdf->download('facture.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $validated = $request->validated();

		$order->quantity = $validated['quantity'] ?? null;
		$order->amount = $validated['amount'] ?? null;
		$order->status = $validated['status'] ?? null;
		$order->product_id = $validated['product_id'] ?? null;
		$order->account_id = $validated['account_id'] ?? null;

        $order->save();

        $data = [
            'success'       => true,
            'order'   => $order
        ];

        return response()->json($data);
    }

    public function account_update(UpdateOrderRequest $request, Order $order)
    {
        $account =  Auth::getUser($request, Auth::ACCOUNT);
        $validated = $request->validated();

        $order->quantity = $validated['quantity'] ?? null;
        $order->amount = $validated['amount'] ?? null;
        $order->product_id = $validated['product_id'] ?? null;
        $order->account_id = $account->id;

        $order->save();

        $data = [
            'success'       => true,
            'order'   => $order
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        $data = [
            'success' => true,
            'order' => $order
        ];

        return response()->json($data);
    }
}
