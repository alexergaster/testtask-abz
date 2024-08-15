<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email|max:50|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'registration_timestamp' => 'date_format:Y-m-d H:i:s',
            'position_id' => 'required|integer|exists:positions,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'phone.required' => 'The phone field is required.',
            'image.required' => 'The image field is required.',
            'name.min' => 'The name must be at least 2 characters.',
            'name.max' => 'The name may not be greater than 60 characters.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 50 characters.',
            'email.unique' => 'The email has already been taken.',
            'phone.max' => 'The phone may not be greater than 15 characters.',
            'image.max' => 'The photo may not be greater than 5 Mbytes.',
            'image.mimes' => 'Incorrect format for image.',
            'position_id.required' => 'The position ID field is required.',
            'position_id.exists' => 'The selected position ID is invalid.',
            'position_id.integer' => 'The position id must be an integer.',
        ];
    }

}
