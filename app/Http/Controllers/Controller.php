<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    protected function Success($massage)
    {
        $data = [
            'massage'=>$massage , 'status'=>200
        ];


        return response()->json($data, 200);
    }


    protected function error($massage, $status)
    {

        $data = [
            'massage' => $massage,
            'status' => $status
        ];

        return response()->json($data, $status);
    }


    protected function storeFile($type, $file, $disk)
    {

        $imageName =  $type . "/" . Carbon::now()->toDateTimeString(). $file->getClientOriginalName();

        Storage::disk($disk)->put($imageName, file_get_contents($file));
        $path = Storage::disk($disk)->url($imageName);
        return  $path;
    }


    protected function deleteFile($filePath, $disk)
    {
        if (Storage::disk($disk)->exists($filePath)) {
            Storage::disk($disk)->delete($filePath);
        }
    }





}
