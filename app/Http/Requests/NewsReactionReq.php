<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class NewsReactionReq extends FormRequest
{


    public function rules(): array
    {
        return [
            'news_id' => 'required|numeric|exists:news,id',
            'reaction'=>'required|numeric|in:1,-1'
        ];
    }


    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([


            'status'    => 422,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));
    }
}
