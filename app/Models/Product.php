<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'deleted_at',
        'updated_at',
        'created_at'
    ];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
}
