<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'author' => $this->author,
            'image' => $this->image,
            'writer' => $this->whenLoaded('writer'),
            'comments' => $this->whenLoaded('comments', function(){
                return collect($this->comments)->each(function($comment){
                    $comment->commentator;
                    return $comment;
                });
            }),
            'created_at' => $this->created_at,
        ];
    }
}
