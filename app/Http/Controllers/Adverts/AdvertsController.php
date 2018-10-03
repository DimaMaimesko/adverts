<?php
namespace App\Http\Controllers\Adverts;
use App\Http\Controllers\Controller;
use App\Models\Adverts\Advert;
use App\Models\Region;
use App\Models\Adverts\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Router\AdvertsPath;
use App\Services\Advert\AdvertService;

class AdvertsController extends Controller
{
    private $service;

    public function __construct(AdvertService $service)
    {
        $this->service = $service;
    }


    public function index( AdvertsPath $path )
    {
        $query = Advert::with(['region','category'])->orderByDesc('published_at');

        if ($category = $path->category){
            $query->forCategory($category);
        }
        if ($region = $path->region){
            $query->forRegion($region);
        }

        $regions = $region
            ? $region->children()->orderBy('name')->getModels()
            : Region::roots()->orderBy('name')->getModels();

        $categories = $category
            ? $category->children()->defaultOrder()->getModels()
            : Category::whereIsRoot()->defaultOrder()->getModels();

        $adverts = $query->get();

        return view('adverts.index',compact(['category','region','regions', 'categories', 'adverts']));
    }

    public function show()
    {

    }





}