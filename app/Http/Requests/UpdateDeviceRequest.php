<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('device'));
    }

    public function rules(): array
    {
        return [
            'device_type' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'specifications' => 'nullable|string|max:2000',
            'category_id' => 'required|exists:device_categories,id',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'warranty_expiry' => 'nullable|date',
            'status' => 'required|in:active,needs_attention,replacement_needed,stolen',
        ];
    }
}
