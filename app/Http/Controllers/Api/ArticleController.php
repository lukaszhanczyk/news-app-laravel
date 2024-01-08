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
        $search = $request->query('search');
        $dateFrom = $request->query('dateFrom');
        $dateTo = $request->query('dateTo');

        $articles = Article::query();

        if ($apis and count($apis) > 0){
            $articles->whereIn('api_source_id', $apis);
        }
        if ($sources and count($sources) > 0){
            $articles->whereIn('source_id', $sources);
        }
        if ($categories and count($categories) > 0){
            $articles->whereIn('category_id', $categories);
        }
        if ($authors and count($authors) > 0){
            $articles->whereHas('authors', function (Builder $query) use ($authors) {
                $query->whereIn('authors.id', $authors);
            });
        }
        if ($dateTo){
            $articles->where('published_at', '<=', $dateTo);
        }
        if ($dateFrom){
            $articles->where('published_at', '>=', $dateFrom);
        }

        if ($search){
            $articles->where(function($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        return ArticleResource::collection(
            $articles->orderBy('published_at', 'desc')->paginate(10)
        );
    }
}
