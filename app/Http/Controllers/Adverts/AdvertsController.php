<?php
namespace App\Http\Controllers\Adverts;
use App\Http\Controllers\Controller;
use App\Models\Adverts\Advert;
use App\Models\Region;
use App\Models\Adverts\Category;
use Illuminate\Support\Facades\Auth;
use App\Services\Advert\AdvertService;

class AdvertsController extends Controller
{
    private $service;

    public function __construct(AdvertService $service)
    {
        $this->service = $service;
    }

    public function index(Category $category = null, Region $region = null)
    {

//        if ($category){
//            $query->forCategory($category);
//        }
//        if ($region){
//            $query->forRegion($region);
//        }


        if ($category){
            $categories = $category->children->toArray();
        }else{
            $categories = Category::whereIsRoot()->defaultOrder()->getModels();
        }
        if ($region){
            $regions = $region->children->toArray();;
        }else{
            $regions  = Region::roots()->orderBy('name')->getModels();
        }

        $query = Advert::with(['region','category','user'])->orderByDesc('title');
        $adverts = $query->get();

        return view('adverts.index',compact(['regions', 'categories', 'adverts']));
    }

    public function show()
    {

    }





}