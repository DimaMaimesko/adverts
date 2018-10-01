<?php
/**
 * Created by PhpStorm.
 * User: дз
 * Date: 29.09.2018
 * Time: 20:26
 */

namespace App\Http\Controllers\Cabinet\Adverts;


use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Http\Requests\Adverts\CreateRequest;
use App\Models\Adverts\Category;
use App\Models\Region;
use App\Services\Advert\AdvertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    private $service;

    public function __construct(AdvertService $service)
    {
        $this->middleware(FilledProfile::class);
        $this->service = $service;
    }

    public function category()
    {
        $categories = Category::defaultOrder()->withDepth()->get()->toTree();
        return view('cabinet.adverts.create.category', compact('categories'));
    }

    public function region(Category $category, Region $region = null)
    {
        $regions = Region::where('parent_id', $region ? $region->id : null)->orderBy('name')->get();
        return view('cabinet.adverts.create.region', compact(['category', 'region', 'regions']));
    }

    public function advert(Category $category, Region $region = null)
    {
        return view('cabinet.adverts.create.advert', compact(['category', 'region']));
    }

    public function store(Category $category, Region $region = null, CreateRequest $request)
    {
        try {
            $advert = $this->service->create(
                Auth::id(),
                $category->id,
                $region ? $region->id : null,
                $request
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back(    );
    }


}