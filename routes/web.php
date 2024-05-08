<?php

use App\Models\Account;
use App\Models\User;
use App\Psssp;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


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

Route::get('accounts/{account}/invoice', function(Request $request, Account $account) {
    $sponsor = null;

    $account->user;

    if (isset($account->referer_sponsor_code)) {
        $sponsor = User::where('sponsor_code',
        $account->referer_sponsor_code)->firstOrFail();
    } else {
        $sponsor = Psssp::getSolidariteUser();
    }

    $seller = $sponsor->accounts()
    ->orderBy('created_at', 'desc')->first();
    $seller['user'] = $sponsor;
    $data = [
        'order' => [
            'seller' => $seller,
            'buyer' => $account
        ]
    ];

    $pdf = PDF::loadView('invoice', $data);
    $pdf->setPaper('A4', 'landscape');

    return $pdf->stream('facture.pdf');
});

Route::get('/supprimer', function(){
    return view('supprimer');
});

Route::get('/admin/{any}', function () {
    return view('admin');
})->where('any', '(.*)?');

Route::any('/{any}', function () {
    return view('user');
})->where('any', '(.*)?');
