<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowNewsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'title' => $this->title,

            'image' => $this->image,
            'body'=>$this->body,
            'pre_description' => $this->pre_description,
            'viewCount' => $this->viewCount,
            'commentCount' => $this->commentCount,
            'created_at' => MiladiToShamsi( $this->created_at),
            'likes'=>$this->likes ,
            'disslikes'=>$this->disslikes ,
            
            'reactionStatus'=>$this->reactionStatus($request->ip()),
            'comments'=>  CommentsResource::collection($this->availableComments) ,
            'tags'=>  tagsResource::collection($this->tags)
        ];
    }
}
