<?php



namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Device::class);
    }

    public function rules(): array
    {
        return [
            'unique_identifier' => 'required|string|max:255|unique:devices,unique_identifier',
            'device_type' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'specifications' => 'nullable|string|max:2000',
            'category_id' => 'required|exists:device_categories,id',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'warranty_expiry' => 'nullable|date|after:today',
            
            // Buyer information (optional for initial registration)
            'buyer_email' => 'nullable|email|max:255',
            'buyer_full_name' => 'required_with:buyer_email|string|max:255',
            'buyer_phone' => 'required_with:buyer_email|string|max:20',
            'buyer_address' => 'required_with:buyer_email|string|max:500',
            'buyer_city' => 'required_with:buyer_email|string|max:255',
            'buyer_state' => 'required_with:buyer_email|string|max:255',
            'buyer_country' => 'nullable|string|max:255',
            'buyer_id_type' => 'nullable|string|max:50',
            'buyer_id_number' => 'nullable|string|max:50',
            'buyer_category' => 'required_with:buyer_email|in:individual,institution,corporate',
            'institution_name' => 'required_if:buyer_category,institution,corporate|string|max:255',
            'tax_id' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'unique_identifier.required' => 'Device identifier (PG/Serial Number) is required.',
            'unique_identifier.unique' => 'This device identifier is already registered in the system.',
            'category_id.required' => 'Please select a device category.',
            'category_id.exists' => 'Selected category is invalid.',
            'buyer_email.email' => 'Please provide a valid email address for the buyer.',
            'buyer_full_name.required_with' => 'Buyer full name is required when buyer email is provided.',
            'buyer_phone.required_with' => 'Buyer phone number is required when buyer email is provided.',
            'buyer_address.required_with' => 'Buyer address is required when buyer email is provided.',
            'buyer_city.required_with' => 'Buyer city is required when buyer email is provided.',
            'buyer_state.required_with' => 'Buyer state is required when buyer email is provided.',
            'buyer_category.required_with' => 'Buyer category is required when buyer email is provided.',
            'institution_name.required_if' => 'Institution name is required for institutional and corporate buyers.',
        ];
    }

    public function prepareForValidation(): void
    {
        // Clean and format data before validation
        $this->merge([
            'unique_identifier' => strtoupper(trim($this->unique_identifier)),
            'buyer_email' => strtolower(trim($this->buyer_email ?? '')),
            'buyer_phone' => preg_replace('/[^0-9+]/', '', $this->buyer_phone ?? ''),
        ]);
    }
}