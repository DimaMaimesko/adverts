<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Adverts\Advert\Photo;
use  App\Http\Requests\Adverts\PhotosRequest;
//use Intervention\Image\ImageManagerStatic as Image;
class PhotosController extends Controller
{

    public function uploadFiles( $advert, PhotosRequest $request)
    {
        $files = $request->file('picture');
        $pathToStorage = 'public/adverts/' . $advert;
        Storage::makeDirectory($pathToStorage);
        foreach ($files as $file){
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($pathToStorage, $filename, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $url = Storage::disk('s3')->url($path);
            //$pathToDb = 'storage/adverts/' . $advert . '/' . $filename;
            $pathToDb = $url;
            Photo::create([
                'advert_id' => $advert,
                'photo' => $pathToDb,
                'title' => $request->title,
                'size' => $file->getSize(),
                'description' => $request->description,
            ]);
        }
        return back();
    }

}