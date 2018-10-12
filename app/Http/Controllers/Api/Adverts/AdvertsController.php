<?php
namespace App\Http\Controllers\Api\Adverts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\SearchRequest;
use App\Models\Adverts\Advert;
use App\Models\Region;
use App\Models\Adverts\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Router\AdvertsPath;
use App\Services\Advert\AdvertService;
use App\Services\Search\SearchService;
use App\Http\Resources\Adverts\AdvertListResource;
use App\Http\Resources\Adverts\AdvertDetailResource;
class AdvertsController extends Controller
{
    private $service;
    private $search;

    public function __construct(AdvertService $service, SearchService $search)
    {
        $this->service = $service;
        $this->search = $search;
    }


    public function index(SearchRequest $request)
    {
        $region = $request->get('region') ? Region::findOrFail($request->get('region')) : null;
        $category = $request->get('category') ? Category::findOrFail($request->get('category')) : null;

        $result = $this->search->search($category, $region, $request, 20, $request->get('page', 1));

        return AdvertListResource::collection($result->adverts);

    }

    public function show(Advert $advert)
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        return new AdvertDetailResource($advert);

    }
}






