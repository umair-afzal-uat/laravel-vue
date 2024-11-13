<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSystemEventRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'event_type' => 'required|string',
            'event_description' => 'required|string',
            'event_data' => 'nullable|array',
        ];
    }
}