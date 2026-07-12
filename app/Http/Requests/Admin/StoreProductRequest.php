<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasAdminAccess();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'model' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
            'cc' => 'nullable|integer|min:50|max:2000',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'location' => 'nullable|string|max:100',
            'year_manufacture' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'year_assembly' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
            'tax_expiry' => 'nullable|date',
            'odometer' => 'nullable|integer|min:0',
            // Booleans
            'routine_service' => 'nullable|boolean',
            'service_book' => 'nullable|boolean',
            'modifications_legal' => 'nullable|boolean',
            'accident_history' => 'nullable|boolean',
            'flood_history' => 'nullable|boolean',
            'frame_damage' => 'nullable|boolean',
            'repainted' => 'nullable|boolean',
            'engine_overhaul' => 'nullable|boolean',
            'spare_key' => 'nullable|boolean',
            'toolkit' => 'nullable|boolean',
            'manual_book' => 'nullable|boolean',
            'bonus_helmet' => 'nullable|boolean',
        ];
    }
}
