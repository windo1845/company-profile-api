<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with('user')->latest()->get();
        return view('website.index', compact('websites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:100',
            'domain' => 'nullable|string|max:150',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // simpan ke storage/app/public/website_images
            $path = $request->file('image')->store('website_images', 'public');
        }

        Website::create([
            'user_id' => Auth::id(),
            'nama'    => ucwords($request->nama),
            'domain'  => $request->domain,
            'image'   => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Website berhasil ditambahkan'
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:website,id',
        ]);

        $website = Website::findOrFail($request->id);

        // hapus file image kalau ada
        if ($website->image && Storage::disk('public')->exists($website->image)) {
            Storage::disk('public')->delete($website->image);
        }

        $website->delete();

        return response()->json([
            'success' => true,
            'message' => 'Website berhasil dihapus'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:website,id',
            'nama'   => 'required|string|max:100',
            'domain' => 'nullable|string|max:150',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $website = Website::findOrFail($request->id);

        // kalau ada gambar baru, hapus lama & simpan baru
        if ($request->hasFile('image')) {
            if ($website->image && Storage::disk('public')->exists($website->image)) {
                Storage::disk('public')->delete($website->image);
            }
            $website->image = $request->file('image')->store('website_images', 'public');
        }

        $website->nama   = ucwords($request->nama);
        $website->domain = $request->domain;
        $website->save();

        return response()->json([
            'success' => true,
            'message' => 'Website berhasil diupdate'
        ]);
    }

    public function select(Request $request)
    {
        $website = Website::findOrFail($request->website_id);
        
        session([
            'selected_website_id' => $website->id,
            'selected_website_domain' => $website->domain,
            'selected_website_name' => $website->nama,
            'selected_website_image' => $website->image,
        ]);
    
        return back();
    }

}
