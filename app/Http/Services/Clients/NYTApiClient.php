<?php

namespace App\Http\Services\Clients;

use Illuminate\Support\Facades\Http;

class NYTApiClient implements HttpApiClient
{

    public function get()
    {
        return Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json', [
            'sort' => 'newest',
            'api-key' => config('services.nyt_api.key')
        ]);
    }
}
