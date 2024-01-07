<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $apis = $request->query('api');
        $sources = $request->query('source');
        $categories = $request->query('category');
        $authors = $request->query('author');


        $articles = Article::query();
        if ($apis and count($apis) > 0){
            $articles->orWhereIn('api_source_id', $apis);
        }
        if ($sources and count($sources) > 0){
            $articles->orWhereIn('source_id', $sources);
        }
        if ($categories and count($categories) > 0){
            $articles->orWhereIn('category_id', $categories);
        }
        if ($authors and count($authors) > 0){
            $articles->orWhereHas('authors', function (Builder $query) use ($authors) {
                $query->whereIn('authors.id', $authors);
            });
        }

        return ArticleResource::collection(
            $articles->orderBy('published_at', 'desc')->paginate(10)
        );
    }
}
