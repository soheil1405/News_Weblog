<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'news_id' => $this->news_id,
            'answered_to '=>$this->answered_to ? $this->parent->writer : null,
            'writer'=>$this->writer ,
            'comment_body'=>$this->comment_body ,
            'likes'=>$this->likes ,
            'disslikes'=>$this->disslikes ,
            
            'ReactStatus'=>$this->reactionStatus($request->ip()),
            'answers'=> CommentsResource::collection($this->availableAnswers)

        ];
    }
}
