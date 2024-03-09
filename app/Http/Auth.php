<?php

namespace App\Http;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Admin;


class Auth {
    public const ADMIN = "admin";
    public const USER = "user";
    public const ACCOUNT = "account";

    public static function getUser(Request $request, string $type='client')
    {
        $token = $request->header('Authorization') ?
         explode(" ", $request->header('Authorization'))[1] : null;
        $user = null;

        switch ($type) {
            case self::ADMIN:
                $user = self::getAdminByToken($token);
                break;
            case self::USER:
                $user = self::getUserByToken($token);
                break;
            case self::ACCOUNT:
                $user = self::getAccountByToken($token);
                break;
            default:
                $user = self::getUserByToken($token);
                break;
        }

        return $user;
    }

    private static function getAdminByToken(string $token)
    {
        return Admin::where('api_token', $token)->first();
    }

    private static function getUserByToken($token)
    {
        return User::where('api_token', $token)->first();

    }
    private static function getAccountByToken($token) {
        return Account::where('api_token', $token)->first();
    }
}
