<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Session;
class ZohoApiService
{
    private string|null $accessToken = null;
    public function __construct()
    {
        $this->accessToken = session()->get('access_token');
    }
    public function getDeals(null|int $accountId = null): array|object
    {
        $response = $this->prepareRequest()->get('{+domain}/deals', []);

        if ($response->successful()) {
            $deals = $response->object()->data;
            if ($accountId) {
                $deals = $this->filterDealsByAccountId($deals, $accountId);
            }
            return $deals;
        }

        return [];
    }
    public function storeDeal(array $formData): null|string
    {
        $data = $this->prepareDataForRequest($formData);
        $response = $this->prepareRequest()->post('{+domain}/Deals', $data);
        return $this->checkAPIResponse($response);
    }
    public function updateDeal(int $dealId, array $formData): ?string
    {
        $formData['id'] = $dealId;
        $data = $this->prepareDataForRequest($formData);
        $response = $this->prepareRequest()->put('{+domain}/Deals', $data);
        return $this->checkAPIResponse($response);
    }
    public function getAccounts(): array|object
    {
        $response = $this->prepareRequest()->get('{+domain}/Accounts', []);

        if ($response->successful()) {
            return $response->object()->data;
        }

        return [];
    }
    public function storeAccount(array $formData): null|string
    {
        $data = $this->prepareDataForRequest($formData);
        $response = $this->prepareRequest()->post('{+domain}/Accounts', $data);
        return $this->checkAPIResponse($response);
    }
    public function getDeal(int $dealId): array|object
    {
        $response = $this->prepareRequest()->get('{+domain}/deals/' . $dealId, []);

        if ($response->successful()) {
            return isset($response->object()->data[0]) ? $response->object()->data[0] : [];
        }

        return [];
    }
    private function prepareRequest(): PendingRequest
    {
        $this->checkTokenValidity();
        return Http::withUrlParameters([
            'domain' => 'https://www.zohoapis.eu/crm/v2',
        ])->withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ]);
    }

    private function checkTokenValidity(): void
    {
        // Робимо тестовий запит до Zoho CRM API
        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $this->accessToken,
        ])->get('https://www.zohoapis.eu/crm/v2/Leads');

        if ($response->status() === 401) { // Код 401 означає, що токен недійсний
            $this->refreshAccessToken(); // Оновлюємо токен
        }
    }
    private function refreshAccessToken(): void
    {
        $data = [
            'client_id' => config('app.zoho_client_id'),
            'client_secret' => config('app.zoho_client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => config('app.zoho_refresh_token'),
        ];
        $response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', $data);

        if ($response->successful()) {
            $responseData = $response->object();
            session()->put('access_token', $responseData->access_token);
            $this->accessToken = $responseData->access_token;
        }
    }
    private function prepareDataForRequest(array $formData): array
    {
        $data = [];
        $data['data'][] = $formData;

        return $data;
    }
    private function checkAPIResponse(\Illuminate\Http\Client\Response $response): null|string
    {
        if ($response->successful()) {
            return response()->json([
                'error' => null,
                'status_code' => $response->status(),
                'details' => $response->object()->data,
            ]);
        }
        if ($response->failed()) { // Check if the response is a failure
            return response()->json([
                'error' => 'Something went wrong',
                'status_code' => $response->status(),
                'details' => $response->body(),
            ], 500);
        }
    }

    private function filterDealsByAccountId(array $deals, string $accountId): array
    {
        return array_filter($deals, function ($deal) use ($accountId) {
            if ($deal->Account_Name) {
                return $deal->Account_Name->id == $accountId;
            }
        });
    }
}
