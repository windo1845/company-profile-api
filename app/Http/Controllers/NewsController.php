<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $query = News::orderBy('id', 'desc');
    
        if (session('selected_website_id')) {
            $query->where('website_id', session('selected_website_id'));
        }
    
        $news = $query->get();
    
        return view('news.index', compact('news'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:20',
            'judul_en' => 'required|string|max:20',
            'isi' => 'nullable|string',
            'isi_en' => 'nullable|string',
            'tanggal' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'website_id'=> 'required|exists:website,id',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imagePath = $file->store('news_images', 'public');
        }
    
        News::create([
            'user_id' => auth()->id(),
            'website_id' => $request->website_id,
            'judul' => ucwords($request->judul),
            'judul_en' => ucwords($request->judul_en),
            'isi' => $request->isi,
            'isi_en' => $request->isi_en,
            'tanggal' => $request->tanggal,
            'image' => $imagePath,
        ]);
    
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $news = News::findOrFail($request->id);
    
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }
    
        $news->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'News berhasil dihapus'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:news,id',
            'judul' => 'required|string|max:20',
            'judul_en' => 'required|string|max:20',
            'isi' => 'nullable|string',
            'isi_en' => 'nullable|string',
            'tanggal' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'website_id'=> 'required|exists:website,id',
        ]);
    
        $news = News::findOrFail($request->id);
    
        if ($request->hasFile('image')) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
    
            $file = $request->file('image');
            $imagePath = $file->store('news_images', 'public');
            $news->image = $imagePath;
        }
    
        $news->website_id = $request->website_id;
        $news->judul = ucwords($request->judul);
        $news->judul_en = ucwords($request->judul_en);
        $news->isi = $request->isi;
        $news->isi_en = $request->isi_en;
        $news->tanggal = $request->tanggal;
        $news->updated_by = auth()->id();
        
        $news->save();
    
        return response()->json(['success' => true]);
    }

}
