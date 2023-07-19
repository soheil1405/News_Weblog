<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;


class StorecommentsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'news_id' => 'required|numeric|exists:news,id',
            'answered_to' => 'nullable|numeric|exists:comments,id',
            'writer' => 'required|string',
            'comment_body' => 'required|persian_alpha',
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
