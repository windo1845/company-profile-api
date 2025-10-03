<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $query = Video::orderBy('id', 'desc');
    
        if (session('selected_website_id')) {
            $query->where('website_id', session('selected_website_id'));
        }
    
        $videos = $query->get();
    
        return view('video.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'website_id' => 'required|integer',
            'video_file' => 'required|file|mimes:mp4,mov,avi,wmv|max:51200',
        ]);
    
        $path = $request->file('video_file')->store('videos', 'public');
    
        Video::create([
            'judul' => $request->judul,
            'website_id' => $request->website_id,
            'link_video' => $path,
            'user_id' => auth()->id(),
        ]);
    
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $video = Video::findOrFail($request->id);

        if ($video->link_video && Storage::disk('public')->exists($video->link_video)) {
            Storage::disk('public')->delete($video->link_video);
        }

        $video->delete();

        return response()->json([
            'success' => true,
            'message' => 'Video berhasil dihapus'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'judul' => 'required|string|max:255',
            'website_id' => 'required|integer',
            'link_video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
        ]);
    
        $video = Video::findOrFail($request->id);
        $video->judul = $request->judul;
        $video->website_id = $request->website_id;
    
        if ($request->hasFile('link_video')) {
            if ($video->link_video && Storage::disk('public')->exists($video->link_video)) {
                Storage::disk('public')->delete($video->link_video);
            }
    
            $path = $request->file('link_video')->store('videos', 'public');
            $video->link_video = $path;
        }
    
        $video->updated_by = auth()->id();
        $video->save();
    
        return response()->json(['success' => true]);
    }
    

}
