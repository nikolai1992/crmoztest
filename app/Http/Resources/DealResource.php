<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
            'id' => $this->id,
            'Deal_Name' => $this->Deal_Name,
            'Stage' => $this->Stage,
            'Account_Name' => [
                'id' => $this->Account_Name->id ?? null,
                "name" => $this->Account_Name->name ?? null,
            ]

		];
	}
}
