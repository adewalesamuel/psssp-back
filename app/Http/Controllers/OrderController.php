<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Str;
use App\Http\Auth;


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
            'orders' => Order::where('id', '>', -1)
            ->orderBy('created_at', 'desc')->paginate()
        ];

        return response()->json($data);
    }

    public function user_index(Request $request) {
        $user =  Auth::getUser($request, Auth::USER);
        $status = $request->input('status');
        $orders = Order::where('user_id', $user->id):

        if ($status) $orders = $orders->where('status', $status);

        $data = [
            'success' => true,
            'orders' => $orders->orderBy('created_at', 'desc')->paginate()
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

        $order->code = $validated['code'] ?? null;
		$order->quantity = $validated['quantity'] ?? null;
		$order->amount = $validated['amount'] ?? null;
		$order->status = $validated['status'] ?? null;
		$order->product_id = $validated['product_id'] ?? null;
		$order->user_id = $validated['user_id'] ?? null;
		
        $order->save();

        $data = [
            'success'       => true,
            'order'   => $order
        ];
        
        return response()->json($data);
    }

    public function user_store(StoreOrderRequest $request)
    {
        $user =  Auth::getUser($request, Auth::USER);
        $validated = $request->validated();

        $order = new Order;

        $order->code = strtoupper(Str::random(10));
        $order->quantity = $validated['quantity'] ?? null;
        $order->amount = $validated['amount'] ?? null;
        $order->product_id = $validated['product_id'] ?? null;
        $order->user_id = $user->id;
        
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

        $order->code = $validated['code'] ?? null;
		$order->quantity = $validated['quantity'] ?? null;
		$order->amount = $validated['amount'] ?? null;
		$order->status = $validated['status'] ?? null;
		$order->product_id = $validated['product_id'] ?? null;
		$order->user_id = $validated['user_id'] ?? null;
		
        $order->save();

        $data = [
            'success'       => true,
            'order'   => $order
        ];
        
        return response()->json($data);
    }

    public function user_update(UpdateOrderRequest $request, Order $order)
    {
        $user =  Auth::getUser($request, Auth::USER);
        $validated = $request->validated();

        $order->quantity = $validated['quantity'] ?? null;
        $order->amount = $validated['amount'] ?? null;
        $order->product_id = $validated['product_id'] ?? null;
        $order->user_id = $user->id;
        
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