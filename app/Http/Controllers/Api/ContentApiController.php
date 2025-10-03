<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Slides;
use App\Models\News;
use App\Models\Video;

class ContentApiController extends Controller
{
    public function products()
    {
        $query = DB::table('products')
            ->join('website', 'website.id', '=', 'products.website_id')
            ->select('products.id','products.user_id',
                'products.website_id','website.nama as website_nama',
                'products.nama_produk','products.product_name',
                'products.keterangan_produk','products.product_description',
                'products.image',
                'products.ukuran_produk_kg','products.ukuran_produk_kg_pcs',
                'products.ukuran_produk_g','products.ukuran_produk_g_pcs',
                'products.tanggal','products.active'
            )
            ->orderBy('products.id', 'asc');
    
        if (request()->has('id')) {
            $query->where('products.website_id', request('id'));
        }
    
        $products = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function news()
    {
        $query = DB::table('news')
            ->join('website', 'website.id', '=', 'news.website_id')
            ->select('news.id','news.user_id',
                'news.website_id','website.nama as website_nama',
                'news.judul','news.judul_en',
                'news.isi','news.isi_en',
                'news.tanggal','news.image'
            )
            ->orderBy('news.id', 'asc');
    
        if (request()->has('id')) {
            $query->where('news.website_id', request('id'));
        }
    
        $news = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }
    
    public function slides()
    {
        $query = DB::table('slides')
            ->join('website', 'website.id', '=', 'slides.website_id')
            ->select('slides.id','slides.user_id',
                'slides.website_id','website.nama as website_nama',
                'slides.title','slides.image'
            )
            ->orderBy('slides.id', 'asc');
    
        if (request()->has('id')) {
            $query->where('slides.website_id', request('id'));
        }
    
        $slides = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    public function video()
    {
        $query = DB::table('video')
            ->join('website', 'website.id', '=', 'video.website_id')
            ->select('video.id','video.user_id',
                'video.website_id','website.nama as website_nama',
                'video.judul','video.link_video'
            )
            ->orderBy('video.id', 'asc');
    
        if (request()->has('id')) {
            $query->where('video.website_id', request('id'));
        }
    
        $video = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $video
        ]);
    }

    public function menumaster()
    {
        $query = DB::table('menu_master')
            ->join('website', 'website.id', '=', 'menu_master.website_id')
            ->select(
                'menu_master.id','menu_master.website_id',
                'website.nama as website_nama',
                'menu_master.title','menu_master.link','menu_master.active'
            )
            ->orderBy('menu_master.id', 'asc');
    
        if (request()->has('id')) {
            $query->where('menu_master.website_id', request('id'));
        }
    
        $video = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $video
        ]);
    }

    public function submenu()
    {
        $query = DB::table('menu_sub')
            ->join('website', 'website.id', '=', 'menu_sub.website_id')
            ->join('menu_master', 'menu_master.id', '=', 'menu_sub.menu_master_id')
            ->select(
                'menu_sub.id',
                'menu_sub.menu_master_id',
                'menu_master.title as master_title',
                'menu_master.link as master_link',
                'menu_sub.website_id',
                'website.nama as website_nama',
                'menu_sub.title as sub_title',
                'menu_sub.link as sub_link',
                'menu_sub.active as sub_active'
            )
            ->orderBy('menu_sub.id', 'asc');
    
        if (request()->has('id')) {
            $query->where('menu_sub.website_id', request('id'));
        }
    
        $video = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $video
        ]);
    }

    public function pages()
    {
        $query = DB::table('pages')
            ->join('website', 'website.id', '=', 'pages.website_id')
            ->join('menu_master', 'menu_master.id', '=', 'pages.menu_master_id')
            ->join('menu_sub', 'menu_sub.id', '=', 'pages.menu_sub_id')
            ->select(
                'pages.id',
                'pages.website_id',
                'website.nama as website_nama',
            
                'pages.menu_master_id',
                'menu_master.title as menu_master_title',
                'menu_master.link as menu_master_link',
            
                'pages.menu_sub_id',
                'menu_sub.title as menu_sub_title',
                'menu_sub.link as menu_sub_link',
            
                'pages.link as pages_link',
                'pages.title as pages_title',
                'pages.content as pages_content',

                'pages.title_en as pages_title_en',
                'pages.content_en as pages_content_en',
            
                'pages.active as pages_active'
            )
            ->orderBy('menu_sub.id', 'asc');
    
        if (request()->has('id')) {
            $query->where('pages.website_id', request('id'));
        }
    
        $video = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $video
        ]);
    }
}
