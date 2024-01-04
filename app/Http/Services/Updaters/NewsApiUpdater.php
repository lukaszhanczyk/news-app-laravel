<?php

namespace App\Http\Services\Updaters;

use App\Http\Services\Clients\NewsApiClient;

class NewsApiUpdater
{
    private NewsApiClient $newsApiClient;

    public function __construct(NewsApiClient $newsApiClient)
    {
        $this->newsApiClient = $newsApiClient;
    }

    public function update()
    {
        $response = $this->newsApiClient->get();


        var_dump(json_decode($response->body()));

    }
}
