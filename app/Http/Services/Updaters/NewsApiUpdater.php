<?php

namespace App\Http\Services\Updaters;

use App\Http\Services\Clients\NewsApiClient;
use App\Models\ApiSource;
use App\Models\Article;

class NewsApiUpdater extends Updater
{
    private NewsApiClient $newsApiClient;

    public function __construct(NewsApiClient $newsApiClient)
    {
        $this->newsApiClient = $newsApiClient;
    }

    public function update()
    {

        $articles = $this->get();
        $sources = $this->getSources();


        if ($articles['articles']){

            foreach ($articles['articles'] as $article){
                $date = new \DateTime($article['publishedAt']);

                $newArticle = Article::create([
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'url' => $article['url'],
                    'url_to_image' => $article['urlToImage'],
                    'published_at' => date('Y-m-d H:i:s', $date->getTimestamp()),
                ]);


                $apiSource = $this->getApiSource();
                $newArticle->apiSource()->associate($apiSource);

                $sourcesName = $article['source']['name'];

                $source = $this->getObjectFromArray($sourcesName,$sources['sources']);

                if ($source){
                    $newSource = $this->updateSources($source['name']);
                    $newCategory = $this->updateCategories($source['category']);

                    if ($newSource){
                        $newArticle->source()->associate($newSource);
                    }

                    if ($newCategory){
                        $newArticle->category()->associate($newCategory);
                    }
                } else {
                    $firstCategory = $this->getFirstCategory();
                    $newArticle->category()->associate($firstCategory);
                }

                $newArticle->save();

                if ($article['author']){
                    $authors = explode(", ", $article['author']);
                    foreach ($authors as $newAuthor){
                        $author = $this->updateAuthors($newAuthor);
                        if ($author){
                            $newArticle->authors()->attach($author->id);
                        }
                    }
                }
            }
        }
    }

    private function get()
    {
        $response = $this->newsApiClient->get();
        return json_decode($response->body(), true);
    }

    private function getSources()
    {
        $response = $this->newsApiClient->getSources();
        return json_decode($response->body(), true);
    }

    private function getApiSource()
    {
        return ApiSource::where('name', '=', 'NewsApi')->first();
    }
}
