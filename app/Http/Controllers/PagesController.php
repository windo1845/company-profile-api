<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\MenuSub;
use App\Models\MenuMaster;
use App\Models\Website;

class PagesController extends Controller
{
    public function index()
    {
        $query = Pages::orderBy('id','desc');
    
        if (session('selected_website_id')) {
            $query->where('website_id', session('selected_website_id'));

            $menuMasters = MenuMaster::where('website_id', session('selected_website_id'))->get();
            $menuSubs    = MenuSub::where('website_id', session('selected_website_id'))->get();
        } else {
            $menuMasters = MenuMaster::all();
            $menuSubs    = MenuSub::all();
        }
    
        $pages    = $query->with(['website','menuMaster','menuSub'])->get();
        $websites = Website::all();
    
        return view('pages.index', compact('pages','websites','menuMasters','menuSubs'));
    }
     
    public function store(Request $request)
    {
        $request->validate([
            'menu_master_id' => 'required|exists:menu_master,id',
            'menu_sub_id'    => 'nullable|exists:menu_sub,id',
            'website_id'     => 'nullable|exists:website,id',
            'title'          => 'required|string|max:255',
            'link'           => 'required|string|max:255',
            'content'        => 'nullable|string',
            'title_en'       => 'nullable|string|max:255',
            'content_en'     => 'nullable|string',
            'active'         => 'nullable|string|max:10',
        ]);
    
        Pages::create([
            'menu_master_id' => $request->menu_master_id,
            'menu_sub_id'    => $request->menu_sub_id,
            'website_id'     => $request->website_id,
            'title'          => ucwords($request->title),
            'link'           => $request->link,
            'content'        => $request->content,
            'title_en'       => $request->title_en,
            'content_en'     => $request->content_en,
            'active'         => $request->active ?? 'Y',
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Page berhasil ditambahkan'
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pages,id',
        ]);
    
        $page = Pages::findOrFail($request->id);
        $page->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Page berhasil dihapus'
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id'             => 'required|exists:pages,id',
            'menu_master_id' => 'required|exists:menu_master,id',
            'menu_sub_id'    => 'nullable|exists:menu_sub,id',
            'website_id'     => 'nullable|exists:website,id',
            'title'          => 'required|string|max:255',
            'link'           => 'required|string|max:255',
            'content'        => 'nullable|string',
            'title_en'       => 'nullable|string|max:255',
            'content_en'     => 'nullable|string',
            'active'         => 'nullable|string|max:10',
        ]);
    
        $page = Pages::findOrFail($request->id);
    
        $page->menu_master_id = $request->menu_master_id;
        $page->menu_sub_id    = $request->menu_sub_id;
        $page->website_id     = $request->website_id;
        $page->title          = ucwords($request->title);
        $page->link           = $request->link;
        $page->content        = $request->content;
        $page->title_en       = $request->title_en;
        $page->content_en     = $request->content_en;
        $page->active         = $request->active ?? 'Y';
        $page->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Page berhasil diupdate'
        ]);
    }
    
}
