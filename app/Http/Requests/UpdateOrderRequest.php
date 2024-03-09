<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'quantity' => 'nullable|integer',
			'amount' => 'nullable|integer',
			'status' => 'nullable|string',
			'product_id' => 'nullable|integer|exists:products,id',
            'account_id' => 'nullable|integer|exists:accounts,id',
        ];
    }
}
