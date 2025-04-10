<?php

namespace App\Http\Requests\Deal;

use Illuminate\Foundation\Http\FormRequest;

class DealStoreRequest extends FormRequest
{
	public function rules(): array
	{
		return [
            'Deal_Name' => 'required|max:191',
            'Account_Name.id' => 'nullable|integer',
            'Stage' => 'required',
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
