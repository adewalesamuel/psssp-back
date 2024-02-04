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
			'email' => 'required|string|unique',
			'password' => 'required|string|unique',
			'phone_number' => 'required|string|unique',
			'backup_number' => 'required|string|unique',
			'whatsapp_number' => 'required|string|unique',
			'telegram_number' => 'required|string|unique',
			'shop_name' => 'required|string|unique',
			'profile_img_url' => 'nullable|string',
			'is_active' => 'nullable|boolean',
			'sponsor_code' => 'nullable|string',
            'referer_sponsor_code' => 'nullable|string|exists:users,sponsor_code',
			'country_id' => 'required|integer|exists:countries,id',

        ];
    }
}
