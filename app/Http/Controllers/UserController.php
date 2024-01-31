<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Str;


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
            'users' => User::where('id', '>', -1)
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