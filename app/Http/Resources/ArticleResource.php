<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'url_to_image' => $this->url_to_image,
            'published_at' => $this->published_at,
            'source' => $this->source,
            'category' => $this->category,
            'apiSource' => $this->apiSource,
            'authors' => $this->authors,
        ];
    }
}
