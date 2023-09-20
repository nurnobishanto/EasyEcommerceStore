<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SliderController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $sliders = Slider::orderBy('id','DESC')->get();
        return view('admin.sliders.index',compact('sliders'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $sliders = Slider::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.sliders.trashed',compact('sliders'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'background' => 'image|mimes:jpeg,png,jpg,gif|max:3048',
        ]);
        $imagePath = null;
        if($request->file('image')){
            $imagePath = $request->file('image')->store('slider-image');
        }
        $backgroundPath = null;
        if($request->file('background')){
            $backgroundPath = $request->file('background')->store('slider-background');
        }
        $slider = Slider::create([
            'title' =>$request->title,
            'url' =>$request->url,
            'target' =>$request->target,
            'order' =>$request->order,
            'description' =>$request->description,
            'image' =>$imagePath,
            'background' =>$backgroundPath,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
            'status' =>$request->status,
        ]);
        toastr()->success($slider->name.__('global.created_success'),__('global.slider').__('global.created'));
        return redirect()->route('admin.sliders.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $slider = Slider::find($id);
        return view('admin.sliders.show',compact('slider'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $slider = Slider::find($id);
        return view('admin.sliders.edit',compact(['slider']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $slider = Slider::find($id);
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'background' => 'image|mimes:jpeg,png,jpg,gif|max:3048',
        ]);

        $imagePath = $slider->image??null;
        if($request->file('image')){
            $imagePath = $request->file('image')->store('slider-image');
            $old_image_path = "uploads/".$request->image_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $bgPath = $slider->background??null;
        if($request->file('background')){
            $bgPath = $request->file('background')->store('slider-background');
            $old_image_path = "uploads/".$request->background_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $slider->title = $request->title;
        $slider->url = $request->url;
        $slider->target = $request->target;
        $slider->order = $request->order;
        $slider->description = $request->description;
        $slider->status = $request->status;
        $slider->updated_by = auth()->user()->id;
        $slider->image = $imagePath;
        $slider->background = $bgPath;
        $slider->update();
        toastr()->success($slider->name.__('global.updated_success'),__('global.slider').__('global.updated'));
        return redirect()->route('admin.sliders.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $slider = Slider::find($id);
        $slider->delete();
        toastr()->success(__('global.slider').__('global.deleted_success'),__('global.slider').__('global.deleted'));
        return redirect()->route('admin.sliders.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $slider = Slider::withTrashed()->find($id);
        $slider->deleted_at = null;
        $slider->update();
        toastr()->success($slider->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.sliders.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $slider = Slider::withTrashed()->find($id);
        $old_image_path = "uploads/".$slider->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $slider->forceDelete();
        toastr()->success(__('global.slider').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.sliders.trashed');
    }
}
