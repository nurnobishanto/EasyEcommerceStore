<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;


class CategoryController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.categories.index',compact('categories'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $categories = Category::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.categories.trashed',compact('categories'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $categories = Category::all();
        return view('admin.categories.create',compact('categories'));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'slug' => 'unique:categories',
            'status' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('thumbnail')){
            $imagePath = $request->file('thumbnail')->store('category-thumbnail');
        }
        $category = Category::create([
            'name' =>$request->name,
            'description' =>$request->description,
            'parent_id' =>$request->parent_id,
            'slug' => generateUniqueSlug($request->slug??$request->name,Category::class),
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
            'is_featured' =>$request->is_featured,
            'status' =>$request->status,
            'thumbnail' =>$imagePath,

        ]);
        toastr()->success($category->name.__('global.created_success'),__('global.category').__('global.created'));
        return redirect()->route('admin.categories.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $category = Category::find($id);
        return view('admin.categories.show',compact('category'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $category = Category::find($id);
        $categories = Category::where('id','!=',$id)->get();
        return view('admin.categories.edit',compact(['category','categories']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $category = Category::find($id);
        $request->validate([
            'name' => 'required',
            'slug' => 'unique:categories,id,'.$id,
            'status' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $category->thumbnail??null;
        if($request->file('thumbnail')){
            $imagePath = $request->file('thumbnail')->store('category-thumbnail');
            $old_image_path = "uploads/".$request->thumbnail_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $category->name = $request->name;
        $category->slug = generateUniqueSlug($request->slug??$request->name,Category::class,$id);
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->status = $request->status;
        $category->is_featured = $request->is_featured;
        $category->updated_by = auth()->user()->id;
        $category->thumbnail = $imagePath;
        $category->update();
        toastr()->success($category->name.__('global.updated_success'),__('global.category').__('global.updated'));
        return redirect()->route('admin.categories.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $category = Category::find($id);
        $category->delete();
        toastr()->success(__('global.category').__('global.deleted_success'),__('global.category').__('global.deleted'));
        return redirect()->route('admin.categories.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $category = Category::withTrashed()->find($id);
        $category->deleted_at = null;
        $category->update();
        toastr()->success($category->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.categories.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $category = Category::withTrashed()->find($id);
        $old_image_path = "uploads/".$category->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $category->forceDelete();
        toastr()->success(__('global.category').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.categories.trashed');
    }
}
