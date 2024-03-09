<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountSponsor extends Model
{
    use HasFactory, SoftDeletes;

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
