<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Adverts\Advert\Photo;
use  App\Http\Requests\Adverts\PhotosRequest;

class PhotosController extends Controller
{

    public function uploadFiles( $advert, PhotosRequest $request)
    {
        $files = $request->file('picture');
        $pathToStorage = 'public/adverts/' . $advert;
        Storage::makeDirectory($pathToStorage);
        foreach ($files as $file){
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs($pathToStorage, $filename);
            $pathToDb = 'storage/adverts/' . $advert . '/' . $filename;
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