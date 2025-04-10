<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountStoreRequest;
use App\Http\Resources\AccountResource;
use App\Services\ZohoApiService;

class AccountController extends Controller
{
    private ZohoApiService $zohoApiService;
    public function __construct()
    {
        $this->zohoApiService = app(ZohoApiService::class);
    }
    public function index()
    {
        $accounts = $this->zohoApiService->getAccounts();
        return AccountResource::collection($accounts)->resolve();
    }
	public function store(AccountStoreRequest $request)
	{
        $data = $request->all();
        return $this->zohoApiService->storeAccount($data);
	}
}
