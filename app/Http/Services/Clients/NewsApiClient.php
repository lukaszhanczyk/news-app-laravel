<?php

namespace App\Http\Services\Clients;

use Illuminate\Support\Facades\Http;

class NewsApiClient implements HttpApiClient
{

    public function get()
    {
        return Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
            'apiKey' => config('services.news_api.key')
        ]);
    }

    public function getSources()
    {
        return Http::get('https://newsapi.org/v2/top-headlines/sources', [
            'apiKey' => config('services.news_api.key')
        ]);
    }
}
