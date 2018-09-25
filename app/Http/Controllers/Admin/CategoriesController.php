<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoriesCreateValidation;
use App\Http\Requests\Categories\CategoriesUpdateValidation;
use App\Models\Adverts\Category;

class CategoriesController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::defaultOrder()->withDepth()->with('parent')->get();
        return view('admin.categories.index',[
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $parents = [];
        $mdash = html_entity_decode('&mdash; ');
        $categoryDepth = "";
        $categories = Category::defaultOrder()->withDepth()->get();
        foreach ($categories as $key => $category){
            for ($i = 0; $i <= $category->depth; $i++){
                $categoryDepth = $categoryDepth . $mdash;
            }
            $parents[$category->id] = $categoryDepth . $category->name;
            $categoryDepth = "";
        }
        return view('admin.categories.create',[
            'parents' => $parents,
        ]);
    }


    public function store(CategoriesCreateValidation $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id == $request->id ?  null : $request->parent_id,
        ]);
        return redirect()->route('admin.categories.show', $category)->with('success','The New Category successfully created');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parents = [];
        $mdash = html_entity_decode('&mdash; ');
        $categoryDepth = "";
        $categories = Category::defaultOrder()->withDepth()->get();
        foreach ($categories as $key => $cat){
            for ($i = 0; $i <= $cat->depth; $i++){
                $categoryDepth = $categoryDepth . $mdash;
            }
            $parents[$cat->id] = $categoryDepth . $cat->name;
            $categoryDepth = "";
        }
        return view('admin.categories.edit', compact(['category','parents']));
    }

    public function update(CategoriesUpdateValidation $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id == $request->id ?  null : $request->parent_id,
        ]);

        return redirect()->route('admin.categories.show', $category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        flash('Category ' . $category->name . ' destroyed')->warning();
        return redirect()->route('admin.categories.index');
    }

}
