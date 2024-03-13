<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    	'code',
    	'amount',
    	'quantity',
    	'status',
    	'product_id',
    	'account_id'
    ];

	public function product()
	{
		return $this->belongsTo(Product::class)->withTrashed();
	}
	public function account()
	{
		return $this->belongsTo(Account::class);
	}
}
