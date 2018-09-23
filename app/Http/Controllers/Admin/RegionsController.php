<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Regions\RegionsCreateValidation;
use App\Http\Requests\Regions\RegionsUpdateValidation;
use App\Models\Region;

class RegionsController extends Controller
{
    private const REGIONS_FOR_PAGINATION = 10;

    private $allChildrenIds = [];

    public function index(Request $request)
    {
//        $regions = Region::orderBy('id')->paginate(self::REGIONS_FOR_PAGINATION);
        $regions = Region::where('parent_id',null)->orderBy('id')->paginate(self::REGIONS_FOR_PAGINATION);
        return view('admin.regions.index',[
            'regions' => $regions,
        ]);

    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function createsubregion($parent_id)
    {
        return view('admin.regions.create', [
            'parent_id' => $parent_id,
        ]);
    }

    public function store(RegionsCreateValidation $request)
    {
        $region = Region::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id == $request->id ?  null : $request->parent_id,
        ]);
        return redirect()->route('admin.regions.show', $region)->with('success','The New Region successfully created');
    }

    public function show(Region $region)
    {
        $children = $region->children()->orderByDesc('name')->get();
        return view('admin.regions.show', compact(['region', 'children']));
    }

    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    public function update(RegionsUpdateValidation $request, Region $region)
    {
        $region->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id == $request->id ?  null : $request->parent_id,
        ]);

        return redirect()->route('admin.regions.show', $region);
    }

    public function destroy(Region $region)
    {
        $this->getAllChildren($region);
        if (count($this->allChildrenIds) > 0){
            Region::destroy($this->allChildrenIds);
        }
        $region->delete();

        flash('Region ' . $region->name . ' destroyed')->warning();
        flash('And ' . count($this->allChildrenIds) . ' of his children also :)')->warning();
        return redirect()->route('admin.regions.index');
    }

    /**
    *  Recursive searching  of all children of given Region
    */
    private function getAllChildren($region)
    {
        foreach ($region->children as $child){
            $this->allChildrenIds[] = $child->id;
            if (count($child->children) > 0){
                $this->getAllChildren($child);
            }
        }
    }
}
