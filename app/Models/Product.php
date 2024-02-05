<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $guarded = [
        'id',
        'deleted_at',
        'updated_at',
        'created_at'
    ];

    use HasFactory, SoftDeletes;

	public function user()
	{
		return $this->belongsTo(User::class);
	}
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
}
