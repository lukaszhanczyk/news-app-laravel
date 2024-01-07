<?php

namespace App\Http\Services\Updaters;

use App\Http\Services\Clients\GuardianApiClient;
use App\Http\Services\Clients\NYTApiClient;
use App\Models\ApiSource;
use App\Models\Article;

class NYTApiUpdater extends Updater
{
    private NYTApiClient $NYTApiClient;

    public function __construct(NYTApiClient $NYTApiClient)
    {
        $this->NYTApiClient = $NYTApiClient;
    }

    public function update()
    {

        $articles = $this->get()['response']['docs'];

        if ($articles){

            foreach ($articles as $article){

                $date = new \DateTime($article['pub_date']);
                $imgUrl = null;
                if ($article['multimedia'] and count($article['multimedia']) > 0){
                    $imgUrl = 'https://www.nytimes.com/'.$article['multimedia'][0]['url'];
                }

                $newArticle = Article::create([
                    'title' => $article['headline']['main'],
                    'description' => $article['lead_paragraph'],
                    'url' => $article['web_url'],
                    'url_to_image' => $imgUrl,
                    'published_at' => date('Y-m-d H:i:s', $date->getTimestamp()),
                ]);

                $apiSource = $this->getApiSource();
                $newArticle->apiSource()->associate($apiSource);

                $newSource = $this->updateSources($article['source']);
                $newCategory = $this->updateCategories(strtolower($article['section_name']));

                foreach ($article['byline']['person'] as $newAuthor){
                    $author = $this->updateAuthors($newAuthor['firstname'].' '.$newAuthor['lastname']);
                    if ($author){
                        $newArticle->authors()->attach($author->id);
                    }
                }

                if ($newSource){
                    $newArticle->source()->associate($newSource);
                }

                if ($newCategory){
                    $newArticle->category()->associate($newCategory);
                } else {
                    $firstCategory = $this->getFirstCategory();
                    $newArticle->category()->associate($firstCategory);
                }

                $newArticle->save();
            }
        }

    }

    private function get()
    {
        $response = $this->NYTApiClient->get();
        return json_decode($response->body(), true);
    }

    private function getApiSource()
    {
        return ApiSource::where('name', '=', 'NYT')->first();
    }



}
