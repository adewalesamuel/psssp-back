<?php

namespace App;

use App\Models\User;

class Psssp {
	public const SOLIDARITE_LOGIN = 'solidarite';
	public const SOLIDARITE_SPONSOR_CODE = 'CP000000';
	public const SOLIDARITE_PHONE_NUMBER = '000000';

	public static function getSolidariteUser(): User {
		return User::where('sponsor_code', self::SOLIDARITE_SPONSOR_CODE)->firstOrFail();
	}
}