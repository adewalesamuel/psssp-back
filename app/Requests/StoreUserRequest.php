<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'fullname' => 'required|string',
			'email' => 'required|string|unique:users',
			'password' => 'required|string|unique:users',
			'phone_number' => 'required|string|unique:users',
			'backup_number' => 'required|string',
			'whatsapp_number' => 'required|string',
			'telegram_number' => 'required|string',
			'shop_name' => 'required|string',
			'profile_img_url' => 'nullable|string',
			'is_active' => 'nullable|boolean',
			'sponsor_code' => 'nullable|string',
			'activation_code' => 'nullable|string',
			'country_id' => 'required|integer|exists:countries,id',

        ];
    }
}
