<?php

namespace App\Http\Services\Clients;

use Illuminate\Support\Facades\Http;

class GuardianApiClient implements HttpApiClient
{

    public function get()
    {
        return Http::get('https://content.guardianapis.com/search', [
            'page-size' => '50',
            'order-by' => 'newest',
            'show-references' => 'author',
            'show-fields' => 'body',
            'show-tags' => 'contributor',
            'api-key' => config('services.guardian_api.key')
        ]);
    }
}
