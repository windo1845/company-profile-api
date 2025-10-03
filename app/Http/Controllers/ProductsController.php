<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $query = Product::orderBy('id', 'desc');

        if (session('selected_website_id')) {
            $query->where('website_id', session('selected_website_id'));
        }      

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:20',
            'product_name' => 'required|string|max:20',
            'keterangan_produk' => 'nullable|string',
            'product_description' => 'nullable|string',
            'ukuran_produk_kg' => 'nullable|string|max:20',
            'ukuran_produk_kg_pcs' => 'nullable|string|max:20',
            'ukuran_produk_g' => 'nullable|string|max:20',
            'ukuran_produk_g_pcs' => 'nullable|string|max:20',
            'website_id' => 'required|exists:website,id',
            'tanggal' => 'required|date',
            'active' => 'nullable|in:Y,N',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); 
            // simpan ke storage/app/public/products
        }
    
        Product::create([
            'user_id' => auth()->id(),
            'nama_produk' => ucwords($request->nama_produk),
            'website_id' => $request->website_id,
            'product_name' => ucwords($request->product_name),
            'keterangan_produk' => $request->keterangan_produk,
            'product_description' => $request->product_description,
            'ukuran_produk_kg' => $request->ukuran_produk_kg,
            'ukuran_produk_kg_pcs' => $request->ukuran_produk_kg_pcs,
            'ukuran_produk_g' => $request->ukuran_produk_g,
            'ukuran_produk_g_pcs' => $request->ukuran_produk_g_pcs,
            'tanggal' => $request->tanggal,
            'active' => $request->active,
            'image' => $imagePath, 
        ]);
    
        return response()->json(['success' => true]);
    }
    
    public function delete(Request $request)
    {
        $product = Product::find($request->id);
    
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product tidak ditemukan'
            ], 404);
        }
        
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
    
        $product->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Product & gambar berhasil dihapus'
        ]);
    }  

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'nama_produk' => 'required|string|max:20',
            'product_name' => 'required|string|max:20',
            'keterangan_produk' => 'nullable|string',
            'product_description' => 'nullable|string',
            'ukuran_produk_kg' => 'nullable|string|max:20',
            'ukuran_produk_kg_pcs' => 'nullable|string|max:20',
            'ukuran_produk_g' => 'nullable|string|max:20',
            'ukuran_produk_g_pcs' => 'nullable|string|max:20',
            'website_id' => 'required|exists:website,id', 
            'tanggal' => 'required|date',
            'active' => 'nullable|in:Y,N', 
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);
    
        $product = Product::findOrFail($request->id);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
    
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
    
        $product->website_id = $request->website_id;
        $product->nama_produk = ucwords($request->nama_produk);
        $product->product_name = ucwords($request->product_name);
        $product->keterangan_produk = $request->keterangan_produk;
        $product->product_description = $request->product_description;
        $product->ukuran_produk_kg = $request->ukuran_produk_kg;
        $product->ukuran_produk_kg_pcs = $request->ukuran_produk_kg_pcs;
        $product->ukuran_produk_g = $request->ukuran_produk_g;
        $product->ukuran_produk_g_pcs = $request->ukuran_produk_g_pcs;
        $product->tanggal = $request->tanggal;
        $product->active = $request->active;
    
        $product->updated_by = auth()->id();
        $product->save();
    
        return response()->json(['success' => true]);
    }
    
}
