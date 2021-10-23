<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class IntrinioService
{
    protected string $apiKey;
    protected string $apiBaseUrl;

    protected PendingRequest $http;

    public function __construct(string $apiKey, string $apiBaseUrl)
    {
        $this->apiKey = $apiKey;
        $this->apiBaseUrl = $apiBaseUrl;

        $this->http = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->baseUrl($this->apiBaseUrl)->timeout(100);
    }

    public function historicalDataForSecurity(
        string $identifier,
        string $tag,
        string $frequency,
        string $startDate,
        string $endDate,
        int    $pageSize,
        string $nextPage = null
    )
    {
        $response = $this->http->get("securities/${identifier}/historical_data/{$tag}", [
            'frequency' => $frequency,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'page_size' => $pageSize,
            'next_page' => $nextPage,
        ]);

        return $response->json();
    }
}
