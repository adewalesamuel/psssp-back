<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Str;


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