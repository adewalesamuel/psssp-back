<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'fullname' => 'nullable|string',
			'email' => 'nullable|string',
			'password' => 'nullable|string',
			'phone_number' => 'nullable|string',
			'backup_number' => 'nullable|string',
			'whatsapp_number' => 'nullable|string',
			'telegram_number' => 'nullable|string',
			'shop_name' => 'nullable|string',
			'profile_img_url' => 'nullable|string',
			'is_active' => 'nullable|boolean',
			'sponsor_code' => 'nullable|string',
            'referer_sponsor_code' => 'nullable|string|exists:users,sponsor_code',
			'activation_code' => 'nullable|string',
			'country_id' => 'nullable|integer|exists:countries,id',

        ];
    }
}
