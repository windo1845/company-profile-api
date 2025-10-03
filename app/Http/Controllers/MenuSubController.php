<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\MenuSub;
use App\Models\MenuMaster;

class MenuSubController extends Controller
{
    public function index()
    {
        $query = MenuSub::orderBy('id', 'desc');
        $queryMaster = MenuMaster::orderBy('id', 'desc');
    
        if (session('selected_website_id')) {
            $query->where('website_id', session('selected_website_id'));
            $queryMaster->where('website_id', session('selected_website_id'));
        }      
    
        $menuSubs = $query->get();
        $menuMasters = $queryMaster->get();
    
        return view('menusub.index', compact('menuSubs','menuMasters'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'menu_master_id' => 'required|exists:menu_master,id',
            'website_id'     => 'nullable|exists:website,id',
            'title'          => 'required|string|max:255',
            'link'           => 'required|string|max:255',
            'active'         => 'nullable|string|max:10',
        ]);
    
        MenuSub::create([
            'menu_master_id' => $request->menu_master_id,
            'website_id'     => $request->website_id,
            'title'          => ucwords($request->title),
            'link'           => $request->link,
            'active'         => $request->active,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Menu Sub berhasil ditambahkan'
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:menu_sub,id',
        ]);
    
        $menu = MenuSub::findOrFail($request->id);
        $menu->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Menu Sub berhasil dihapus'
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id'             => 'required|exists:menu_sub,id',
            'menu_master_id' => 'required|exists:menu_master,id',
            'website_id'     => 'nullable|exists:website,id',
            'title'          => 'required|string|max:255',
            'link'           => 'required|string|max:255',
            'active'         => 'nullable|string|max:10',
        ]);
    
        $menu = MenuSub::findOrFail($request->id);
    
        $menu->menu_master_id = $request->menu_master_id;
        $menu->website_id     = $request->website_id;
        $menu->title          = ucwords($request->title);
        $menu->link           = $request->link;
        $menu->active         = $request->active;
        $menu->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Menu Sub berhasil diupdate'
        ]);
    }
    
}
