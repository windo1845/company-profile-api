<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Slides;

class SlidesController extends Controller
{
    public function index()
    {
        $query = Slides::orderBy('id', 'desc');
    
        if (session('selected_website_id')) {
            $query->where('website_id', session('selected_website_id'));
        }
    
        $slides = $query->get();
    
        return view('slides.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:100',
            'website_id' => 'nullable|exists:website,id',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // simpan ke storage/app/public/slides_images
            $path = $request->file('image')->store('slides_images', 'public');
        }

        Slides::create([
            'user_id'    => Auth::id(),
            'website_id' => $request->website_id,
            'title'      => ucwords($request->title),
            'image'      => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slide berhasil ditambahkan'
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:slides,id',
        ]);

        $slide = Slides::findOrFail($request->id);

        // hapus file image kalau ada
        if ($slide->image && Storage::disk('public')->exists($slide->image)) {
            Storage::disk('public')->delete($slide->image);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide berhasil dihapus'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'         => 'required|exists:slides,id',
            'title'      => 'required|string|max:100',
            'website_id' => 'nullable|exists:website,id',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        $slide = Slides::findOrFail($request->id);

        if ($request->hasFile('image')) {
            if ($slide->image && Storage::disk('public')->exists($slide->image)) {
                Storage::disk('public')->delete($slide->image);
            }
            $slide->image = $request->file('image')->store('slides_images', 'public');
        }

        $slide->title      = ucwords($request->title);
        $slide->website_id = $request->website_id;
        $slide->updated_by = Auth::id();
        $slide->save();

        return response()->json([
            'success' => true,
            'message' => 'Slide berhasil diupdate'
        ]);
    }

}
