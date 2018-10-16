<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use App\Http\Requests\Categories\PageValidation;

class PagesController extends Controller
{

    public function index()
    {
        $pages = Page::defaultOrder()->withDepth()->get();
        return view('admin.pages.index',[
            'pages' => $pages,
        ]);
    }

    public function create()
    {
        $parents = [];
        $mdash = html_entity_decode('&mdash; ');
        $pageDepth = "";
        $pages = Page::defaultOrder()->withDepth()->get();
        foreach ($pages as $key => $page){
            for ($i = 0; $i <= $page->depth; $i++){
                $pageDepth = $pageDepth . $mdash;
            }
            $parents[$page->id] = $pageDepth . $page->menu_title;
            $pageDepth = "";
        }
        return view('admin.pages.create',[
            'parents' => $parents,
        ]);
    }


    public function store(PageValidation $request)
    {
        $category = Page::create([
            'title' => $request['title'],
            'slug' => $request['slug'],
            'menu_title' => $request['menu_title'],
            'parent_id' => $request->parent_id == $request->id ?  null : $request->parent_id,
            'content' => $request['content'],
            'description' => $request['description'],
        ]);
        return redirect()->route('admin.pages.show', $category)->with('success','The Page successfully created');
    }

    public function show(Page $page)
    {

        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $parents = [];
        $mdash = html_entity_decode('&mdash; ');
        $pageDepth = "";
        $pages = Page::defaultOrder()->withDepth()->get();
        foreach ($pages as $key => $item){
            for ($i = 0; $i <= $item->depth; $i++){
                $pageDepth = $pageDepth . $mdash;
            }
            $parents[$item->id] = $pageDepth . $item->menu_title;
            $pageDepth = "";
        }
        return view('admin.pages.edit',[
            'parents' => $parents,
            'page' => $page,
        ]);
    }

    public function update(PageValidation $request, Page $page)
    {
        $page->update([
            'title' => $request['title'],
            'slug' => $request['slug'],
            'menu_title' => $request['menu_title'],
            'parent_id' => $request->parent_id == $request->id ?  null : $request->parent_id,
            'content' => $request['content'],
            'description' => $request['description'],
        ]);
        return redirect()->route('admin.pages.show', $page);
    }

    public function first(Page $page)
    {
        if ($first = $page->siblings()->defaultOrder()->first()) {
            $page->insertBeforeNode($first);
        }

        return redirect()->route('admin.pages.index');
    }

    public function up(Page $page)
    {
        $page->up();

        return redirect()->route('admin.pages.index');
    }

    public function down(Page $page)
    {
        $page->down();

        return redirect()->route('admin.pages.index');
    }

    public function last(Page $page)
    {
        if ($last = $page->siblings()->defaultOrder('desc')->first()) {
            $page->insertAfterNode($last);
        }

        return redirect()->route('admin.pages.index');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        flash('Page ' . $page->name . ' destroyed')->warning();
        return redirect()->route('admin.pages.index');
    }

}
