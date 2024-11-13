<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserActionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'action_type' => 'required|string',
            'description' => 'required|string',
            'ip_address' => 'required|ip',
        ];
    }
}
