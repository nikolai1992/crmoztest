<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountStoreRequest extends FormRequest
{
	public function rules()
	{
		return [
            'Account_Name' => 'required|max:191',
            'Phone' => 'required|regex:/^\+380\d{9}$/',
            'Website' => 'required|url',
		];
	}

	public function authorize()
	{
		return true;
	}
}
