<?php

namespace App\Http\Controllers;

use App\Models\AccountSponsor;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountSponsorController extends Controller
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
            'account_sponsors' => AccountSponsor::with(['account', 'user'])
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountSponsor  $accountSponsor
     * @return \Illuminate\Http\Response
     */
    public function show(AccountSponsor $accountSponsor)
    {
        //
    }

    public function account_sponsor_show(Request $request, int $account_id) {
            $account_sponsor = AccountSponsor::where(
                'account_id', $account_id)->firstOrFail();
            $sponsor = Account::where('user_id', $account_sponsor->user_id)
            ->with(['user'])->latest()->get();

            $data = [
                'success' => true,
                'sponsor' => $sponsor,
            ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountSponsor  $accountSponsor
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountSponsor $accountSponsor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountSponsor  $accountSponsor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountSponsor $accountSponsor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountSponsor  $accountSponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountSponsor $accountSponsor)
    {
        //
    }
}
