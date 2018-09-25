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
        $regions = Region::where('parent_id',null)->orderBy('sort')->with('parent')->paginate(self::REGIONS_FOR_PAGINATION);
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

    public function up($region){
        $targetRegion = Region::find($region);
        if ($targetRegion->sort > 0){
            $neighborRegion = Region::where('parent_id', $targetRegion->parent_id)->where('sort', $targetRegion->sort - 1)->first();
            $neighborRegion->update(['sort' => $targetRegion->sort]);
            $targetRegion->update(['sort' => $targetRegion->sort - 1]);
            return back()->with('success','Moved up successfully');
        }
        else{
            return back()->with('error','Can\'t be move up');
        }
    }

    public function down($region){
        $targetRegion = Region::find($region);
        $siblingsAmount = Region::where('parent_id', $targetRegion->parent_id)->count();
        if ($targetRegion->sort < $siblingsAmount-1){
            $neighborRegion = Region::where('parent_id', $targetRegion->parent_id)->where('sort', $targetRegion->sort + 1)->first();
            $neighborRegion->update(['sort' => $targetRegion->sort]);
            $targetRegion->update(['sort' => $targetRegion->sort + 1]);
            return back()->with('success','Moved down successfully');
        }
        else{
            return back()->with('error','Can\'t be move down');
        }
    }

    public function first($region){
        $targetRegion = Region::find($region);
        if ($targetRegion->sort > 0){
            Region::where('parent_id', $targetRegion->parent_id)
                 ->where('sort', '>=', 0)
                 ->where('sort', '<', $targetRegion->sort)
                 ->increment('sort');
            $targetRegion->update(['sort' => 0]);
            return back()->with('success','Moved up successfully');
        }
        else{
            return back()->with('error','Can\'t be move up');
        }
    }

    public function last($region){
        $targetRegion = Region::find($region);
        $siblingsAmount = Region::where('parent_id', $targetRegion->parent_id)->count();
        if ($targetRegion->sort < $siblingsAmount - 1){
            Region::where('parent_id', $targetRegion->parent_id)
                ->where('sort', '>=', $targetRegion->sort)
                ->decrement('sort');
            $targetRegion->update(['sort' => $siblingsAmount - 1]);
            return back()->with('success','Moved down successfully');
        }
        else{
            return back()->with('error','Can\'t be move down');
        }
    }
}
