<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserStoreRequest extends FormRequest
{
	public function rules(): array
	{
		return [
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|regex:/^\+380\d{9}$/|unique:users,phone',
            'position_id' => 'required|integer',
            'photo' =>  'required|mimes:jpeg,jpg|max:5120|image|dimensions:min_width=70,min_height=70',
		];
	}

	public function authorize(): bool
	{
		return true;
	}

    public function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],422));
    }
}
