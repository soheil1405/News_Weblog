<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;




class StorenewsRequest extends FormRequest
{

    public function rules(): array
    {
        return [

            'image' => 'nullable|mimes:png,jpg',
            'title' => 'required|string|max:50|min:10|persian_alpha|unique:news',
            'pre_description' => 'required|string|min:30|max:100|persian_alpha',
            'body' => 'required|string',
        ];
    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([


            'status'    => 422,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ],422));
    }


}
