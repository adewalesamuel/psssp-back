<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'backup_number' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'telegram_number' => 'nullable|string',
            'shop_name' => 'nullable|string',
            'profile_img_url' => 'nullable|string',
            'referer_sponsor_code' => 'nullable|string',
            'country_id' => 'nullable|integer|exists:countries,id',
            'user_id' => 'nullable|string|exists:users,id'
        ];
    }
}
