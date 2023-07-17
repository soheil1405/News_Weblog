<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsIndexResource extends JsonResource
{




    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug'=>$this->slug ,
            'image' => $this->image,
            'pre_description' => $this->pre_description,
            'viewCount' => $this->viewCount,
            'commentCount' => $this->commentCount,
            'created_at' => MiladiToShamsi( $this->created_at),
        ];
    }


}
