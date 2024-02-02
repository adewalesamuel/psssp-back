<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Admin;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,  ...$guards)
    {
        $data = [];
        $user = null;
        $token = $request->header('Authorization') ?
        explode(" ", $request->header('Authorization'))[1] : null;

        switch (Arr::first($guards)) {
            case 'admin':
                $user = Admin::where("api_token", $token);
                break;
            case 'user':
                $user = User::where("api_token", $token);
            default:
                $user = User::where("api_token", $token);
                break;
        }

        if (!$token || !$user || !$user->exists()) {
            $data = [
                "error" => true,
                "message" => "Non authentifie"
            ];

            return response()->json($data, 401);
        }

        return $next($request);
    }
}
