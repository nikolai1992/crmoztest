<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\DealStoreRequest;
use App\Http\Requests\Deal\DealUpdateRequest;
use App\Http\Resources\DealResource;
use App\Services\ZohoApiService;

class DealController extends Controller
{
    private ZohoApiService $zohoApiService;
    public function __construct()
    {
        $this->zohoApiService = app(ZohoApiService::class);
    }
	public function index()
	{
        $deals = $this->zohoApiService->getDeals();
        return DealResource::collection($deals)->resolve();
	}
    public function store(DealStoreRequest $request)
    {
        $data = $request->validated();

        return $this->zohoApiService->storeDeal($data);
    }
    public function getDealsByAccountId($accountID)
    {
        $deals = $this->zohoApiService->getDeals($accountID);
        return DealResource::collection($deals)->resolve();
    }
    public function show($id)
    {
        $deal = $this->zohoApiService->getDeal($id);
        return DealResource::make($deal)->resolve();
    }
    public function update(DealUpdateRequest $request, $id)
    {
        $data = $request->validated();

        return $this->zohoApiService->updateDeal($id, $data);
    }
}
