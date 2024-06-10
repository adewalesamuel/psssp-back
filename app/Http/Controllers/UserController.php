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
            'users' => User::orderBy('created_at', 'desc')->paginate()
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

		$user->phone_number = $validated['phone_number'] ?? null;
        $user->sponsor_code = "CP" . Utils::generateRandAlnum();

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

        $user->phone_number = $validated['phone_number'] ?? null;

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

        $user->phone_number = $validated['phone_number'] ?? null;

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
