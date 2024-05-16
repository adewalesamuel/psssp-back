<?php

namespace App;

use App\Models\User;
use App\Models\Account;

class Psssp {
	public const SOLIDARITE_LOGIN = 'solidarite';
	public const SOLIDARITE_SPONSOR_CODE = 'CP000000';
	public const SOLIDARITE_PHONE_NUMBER = '+2250554995992';

	public static function getSolidariteUser(): User {
		return User::where('sponsor_code', self::SOLIDARITE_SPONSOR_CODE)->firstOrFail();
	}

	public static function getSolidariteAccount(): Account {
		return Account::where('email', self::SOLIDARITE_LOGIN)->firstOrFail();
	}
}
