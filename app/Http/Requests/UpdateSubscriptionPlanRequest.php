<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionPlanRequest extends FormRequest
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
            'name' => 'nullable|string',
			'slug' => 'nullable|string',
			'price' => 'nullable|integer',
			'description' => 'nullable|string',
			'num_product' => 'nullable|integer',
			'num_account' => 'nullable|integer',

        ];
    }
}
