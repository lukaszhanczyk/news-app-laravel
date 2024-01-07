<?php

namespace App\Http\Services\Updaters;

use App\Http\Services\Clients\GuardianApiClient;
use App\Models\ApiSource;
use App\Models\Article;

class GuardianApiUpdater extends Updater
{
    private GuardianApiClient $guardianApiClient;

    public function __construct(GuardianApiClient $guardianApiClient)
    {
        $this->guardianApiClient = $guardianApiClient;
    }

    public function update()
    {

        $articles = $this->get()['response']['results'];



        if ($articles){

            foreach ($articles as $article){

                $date = new \DateTime($article['webPublicationDate']);
                $text = strip_tags($article['fields']['body']);
                $text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);;
                $description = substr($text, 0, 300);


                if (strlen($description) >= 100){
                    $description .= "...";
                }

                $newArticle = Article::create([
                    'title' => $article['webTitle'],
                    'description' => $description,
                    'url' => $article['webUrl'],
                    'url_to_image' => null,
                    'published_at' => date('Y-m-d H:i:s', $date->getTimestamp()),
                ]);

                $apiSource = $this->getApiSource();
                $newArticle->apiSource()->associate($apiSource);

                $newSource = $this->updateSources('The Guardian');
                $newCategory = $this->updateCategories(strtolower($article['sectionName']));

                foreach ($article['tags'] as $newAuthor){
                    $author = $this->updateAuthors($newAuthor['webTitle']);
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
        $response = $this->guardianApiClient->get();
        return json_decode($response->body(), true);
    }

    private function getApiSource()
    {
        return ApiSource::where('name', '=', 'Guardian')->first();
    }



}
