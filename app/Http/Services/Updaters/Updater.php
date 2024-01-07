<?php

namespace App\Http\Services\Updaters;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;

class Updater
{
    protected function getObjectFromArray($name, $array) {
        $id = $this->searchForId($name, $array);
        if ($id){
            return $array[$id];
        }
        return null;
    }

    protected function searchForId($name, $array): bool|int|string
    {
        return array_search($name, array_column($array, 'name'));
    }

    protected function getFirstCategory()
    {
        return Category::query()->first();
    }

    protected function updateCategories($name)
    {
        $category = Category::where('name', '=', $name)->first();

        if ($category){
            return $category;
        }

        return Category::create([
            'name' => $name,
        ]);
    }

    protected function updateAuthors($name)
    {
        $author = Author::where('name', '=', $name)->first();

        if ($author){
            return $author;
        }

        return Author::create([
            'name' => $name,
        ]);
    }

    protected function updateSources($name)
    {
        $source = Source::where('name', '=', $name)->first();

        if ($source){
            return $source;
        }

        return Source::create([
            'name' => $name,
        ]);
    }
}
