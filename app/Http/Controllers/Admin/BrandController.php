<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class BrandController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $brands = Brand::orderBy('id','DESC')->get();
        return view('admin.brands.index',compact('brands'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $brands = Brand::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.brands.trashed',compact('brands'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.brands.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'slug' => 'unique:brands',
            'status' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('thumbnail')){
            $imagePath = $request->file('thumbnail')->store('brand-thumbnail');
        }
        $brand = Brand::create([
            'name' =>$request->name,
            'slug' => generateUniqueSlug($request->slug??$request->name,Brand::class),
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
            'status' =>$request->status,
            'is_featured' =>$request->is_featured,
            'thumbnail' =>$imagePath,

        ]);
        toastr()->success($brand->name.__('global.created_success'),__('global.brand').__('global.created'));
        return redirect()->route('admin.brands.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $brand = Brand::find($id);
        return view('admin.brands.show',compact('brand'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $brand = Brand::find($id);
        return view('admin.brands.edit',compact(['brand']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $brand = Brand::find($id);
        $request->validate([
            'name' => 'required',
            'slug' => 'unique:brands,id,'.$id,
            'status' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $brand->thumbnail??null;
        if($request->file('thumbnail')){
            $imagePath = $request->file('thumbnail')->store('brand-thumbnail');
            $old_image_path = "uploads/".$request->thumbnail_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $brand->name = $request->name;
        $brand->slug = generateUniqueSlug($request->slug??$request->name,Brand::class,$id);
        $brand->status = $request->status;
        $brand->is_featured = $request->is_featured;
        $brand->updated_by = auth()->user()->id;
        $brand->thumbnail = $imagePath;
        $brand->update();
        toastr()->success($brand->name.__('global.updated_success'),__('global.brand').__('global.updated'));
        return redirect()->route('admin.brands.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $brand = Brand::find($id);
        $brand->delete();
        toastr()->success(__('global.brand').__('global.deleted_success'),__('global.brand').__('global.deleted'));
        return redirect()->route('admin.brands.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $brand = Brand::withTrashed()->find($id);
        $brand->deleted_at = null;
        $brand->update();
        toastr()->success($brand->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.brands.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $brand = Brand::withTrashed()->find($id);
        $old_image_path = "uploads/".$brand->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $brand->forceDelete();
        toastr()->success(__('global.brand').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.brands.trashed');
    }
}
