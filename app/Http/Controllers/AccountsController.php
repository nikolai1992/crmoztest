<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Http\Resources\DealResource;
use App\Services\ZohoApiService;

class AccountsController extends Controller
{
    private ZohoApiService $zohoApiService;
    public function __construct()
    {
        $this->zohoApiService = app(ZohoApiService::class);
    }
	public function index()
	{
        $accounts = $this->zohoApiService->getAccounts();
        $accounts = $accounts ? AccountResource::collection($accounts)->resolve() : [];

		return view('dashboard.accounts', compact('accounts'));
	}
}
