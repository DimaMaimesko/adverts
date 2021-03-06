<?php
namespace App\Http\Controllers\Adverts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\SearchRequest;
use App\Models\Adverts\Advert;
use App\Models\Region;
use App\Models\Adverts\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Router\AdvertsPath;
use App\Services\Advert\AdvertService;
use App\Services\Search\SearchService;
use App\Events\MessageSended;

class AdvertsController extends Controller
{
    private $service;
    private $search;

    public function __construct(AdvertService $service, SearchService $search)
    {
        $this->service = $service;
        $this->search = $search;
    }


    public function index(SearchRequest $request, AdvertsPath $path)
    {
        $region = $path->region;
        $category = $path->category;

        $regions = $region
            ? $region->children()->orderBy('name')->getModels()
            : Region::roots()->orderBy('name')->getModels();

        $categories = $category
            ? $category->children()->defaultOrder()->getModels()
            : Category::whereIsRoot()->defaultOrder()->getModels();

        $result = $this->search->search($category, $region, $request, 20, $request->get('page', 1));

        $adverts = $result->adverts;
        $regionsCounts = $result->regionsCounts;
        $categoriesCounts = $result->categoriesCounts;
        $user = Auth::user();



        return view('adverts.index', compact([
            'category', 'region',
            'regionsCounts', 'categoriesCounts',
            'regions', 'categories',
            'adverts',
            'user']));
    }

    public function show(Advert $advert)
    {
        //dump(Auth::user()->hasPermissionTo('edit admins'));
        $advert = Advert::find($advert->id);
        $user = Auth::user();



        return view('adverts.show', [
            'advert' => $advert,
            'user' => $user,
        ]);

    }
}





//    public function index( AdvertsPath $path )
//    {
//dd($path);
//        $query = Advert::with(['region','category'])->active()->orderByDesc('published_at');
//
//        if ($category = $path->category){
//            $query->forCategory($category);
//        }
//        if ($region = $path->region){
//            $query->forRegion($region);
//        }
//
//        $regions = $region
//            ? $region->children()->orderBy('name')->getModels()
//            : Region::roots()->orderBy('name')->getModels();
//
//        $categories = $category
//            ? $category->children()->defaultOrder()->getModels()
//            : Category::whereIsRoot()->defaultOrder()->getModels();
//
//        $adverts = $query->get();
//        $user = Auth::user();
//        return view('adverts.index',compact(['category','region','regions', 'categories', 'adverts', 'user']));
//    }




