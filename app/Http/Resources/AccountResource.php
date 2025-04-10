<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
            'id' => $this->id,
            'account_name' => $this->Account_Name,
            'website' => $this->Website,
            'phone' => $this->Phone,
		];
	}
}
