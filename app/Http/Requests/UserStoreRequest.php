<?php

namespace App\Http\Requests;

use App\Rules\ValidImageSizeUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\ValidImageFileTypeUrl;

class UserStoreRequest extends FormRequest
{
	public function rules(): array
	{
		return [
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|regex:/^\+380\d{9}$/|unique:users,phone',
            'position_id' => 'required|integer',
            'photo' =>  ['required', 'url', new ValidImageFileTypeUrl(), new ValidImageSizeUrl()],
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
