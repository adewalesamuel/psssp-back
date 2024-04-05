<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \PDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('orders/{order}/invoice', function(Request $request, Order $order) {
    $order['seller'] = $order->product->account;
    $order['buyer'] = $order->account;

    unset($order['account']);
    unset($order['product']);

    $data = [
        'order' => $order
    ];

    return view('invoice',$data);

    $pdf = PDF::loadView('invoice', $data);
    return $pdf->download('facture.pdf');
});

Route::get('/admin/{any}', function () {
    return view('admin');
})->where('any', '(.*)?');

Route::any('/{any}', function () {
    return view('user');
})->where('any', '(.*)?');
