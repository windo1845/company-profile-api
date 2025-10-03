<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\MenuMaster;

class MenuMasterController extends Controller
{
    public function index()
    {
        $query = MenuMaster::orderBy('id', 'desc');

        if (session('selected_website_id')) {
            $query->where('website_id', session('selected_website_id'));
        }      

        $menuMasters = $query->get();

        return view('menumaster.index', compact('menuMasters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_id' => 'required|exists:website,id',
            'title'      => 'required|string|max:255',
            'link'       => 'required|string|max:255',
            'active'     => 'nullable|string|max:10',
        ]);

        MenuMaster::create([
            'website_id' => $request->website_id,
            'title'      => ucwords($request->title),
            'link'       => $request->link,
            'active'     => $request->active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Menu Master berhasil ditambahkan'
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:menu_master,id',
        ]);

        $menu = MenuMaster::findOrFail($request->id);
        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu Master berhasil dihapus'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'         => 'required|exists:menu_master,id',
            'website_id' => 'required|exists:website,id',
            'title'      => 'required|string|max:255',
            'link'       => 'required|string|max:255',
            'active'     => 'nullable|string|max:10',
        ]);

        $menu = MenuMaster::findOrFail($request->id);

        $menu->website_id = $request->website_id;
        $menu->title      = ucwords($request->title);
        $menu->link       = $request->link;
        $menu->active     = $request->active;
        $menu->save();

        return response()->json([
            'success' => true,
            'message' => 'Menu Master berhasil diupdate'
        ]);
    }

}
