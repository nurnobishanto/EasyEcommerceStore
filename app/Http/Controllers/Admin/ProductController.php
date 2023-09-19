<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $products = Product::orderBy('id','DESC')->get();
        return view('admin.products.index',compact('products'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $products = Product::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.products.trashed',compact('products'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create',compact('products','categories','brands'));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'title' => 'required',
            'slug' => 'unique:products',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'status' => 'required|in:active,deactivate',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            'brand_id' => 'exists:brands,id',
        ]);
        $imagePath = null;
        if($request->file('thumbnail')){
            $imagePath = $request->file('thumbnail')->store('product-thumbnail');
        }
        // Handle gallery images upload
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('product-gallery');
            }
        }
        $product = Product::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => generateUniqueSlug($request->input('slug')??$request->input('title'),Product::class),
            'sku' => $request->input('sku'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'status' => $request->input('status'),
            'thumbnail' => $imagePath,
            'gallery' => $galleryPaths,
            'brand_id' => $request->input('brand_id'),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,

        ]);
        if ($request->has('categories')) {
            $product->categories()->attach($request->input('categories'));
        }
        toastr()->success($product->name.__('global.created_success'),__('global.menu').__('global.created'));
        return redirect()->route('admin.products.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $product = Product::find($id);
        return view('admin.products.show',compact('product'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $product = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit',compact(['product','categories','brands']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $product = Product::find($id);
        $request->validate([
            'title' => 'required',
            'slug' => 'unique:products,id,'.$id,
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'status' => 'required|in:active,deactivate',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            'brand_id' => 'exists:brands,id',
        ]);
        // Remove selected images
        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $image) {
                // Delete the image file from storage
                @unlink($image);
                // Remove the image from the gallery
                $product->gallery = array_values(array_diff($product->gallery, [$image]));
            }
        }


        $imagePath = $product->thumbnail??null;
        if($request->file('thumbnail')){
            $imagePath = $request->file('thumbnail')->store('product-thumbnail');
            $old_image_path = "uploads/".$request->thumbnail_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        // Add new images to the gallery

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('product-gallery');
            }
            $product->gallery = array_merge($galleryPaths,$product->gallery);
        }

        $product->update();
        $product->title = $request->title;
        $product->slug = generateUniqueSlug($request->slug??$request->title,Product::class);
        $product->description = $request->description;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->brand_id = $request->brand_id;
        $product->status = $request->status;
        $product->updated_by = auth()->user()->id;
        $product->thumbnail = $imagePath;
        $product->update();

        toastr()->success($product->name.__('global.updated_success'),__('global.menu').__('global.updated'));
        return redirect()->route('admin.products.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $product = Product::find($id);
        $product->delete();
        toastr()->success(__('global.menu').__('global.deleted_success'),__('global.menu').__('global.deleted'));
        return redirect()->route('admin.products.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $product = Product::withTrashed()->find($id);
        $product->deleted_at = null;
        $product->update();
        toastr()->success($product->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.products.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $product = Product::withTrashed()->find($id);
        $old_image_path = "uploads/".$product->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $product->forceDelete();
        toastr()->success(__('global.menu').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.products.trashed');
    }
}
