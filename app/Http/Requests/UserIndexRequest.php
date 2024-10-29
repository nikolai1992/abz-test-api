<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'count' => 'integer|required|min:1',
			'page' => 'integer|required|min:1',
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
