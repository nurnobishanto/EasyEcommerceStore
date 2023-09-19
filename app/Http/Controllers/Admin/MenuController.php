<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MenuController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $menus = Menu::orderBy('id','DESC')->get();
        return view('admin.menus.index',compact('menus'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $menus = Menu::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.menus.trashed',compact('menus'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $menus = Menu::all();
        return view('admin.menus.create',compact('menus'));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'title' => 'required',
            'url' => 'required|url',
            'status' => 'required',
            'order' => 'numeric|nullable',
        ]);

        $menu = Menu::create([
            'title' =>$request->title,
            'url' =>$request->url,
            'target' =>$request->target,
            'order' =>$request->order,
            'parent_id' =>$request->parent_id,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
            'status' =>$request->status,
        ]);
        toastr()->success($menu->name.__('global.created_success'),__('global.menu').__('global.created'));
        return redirect()->route('admin.menus.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $menu = Menu::find($id);
        return view('admin.menus.show',compact('menu'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $menu = Menu::find($id);
        $menus = Menu::where('id','!=',$id)->get();
        return view('admin.menus.edit',compact(['menu','menus']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $menu = Menu::find($id);
        $request->validate([
            'title' => 'required',
            'url' => 'required|url',
            'status' => 'required',
            'order' => 'numeric|nullable',
        ]);

        $menu->title = $request->title;
        $menu->url = $request->url;
        $menu->target = $request->target;
        $menu->order = $request->order;
        $menu->parent_id = $request->parent_id;
        $menu->status = $request->status;
        $menu->updated_by = auth()->user()->id;

        $menu->update();
        toastr()->success($menu->name.__('global.updated_success'),__('global.menu').__('global.updated'));
        return redirect()->route('admin.menus.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $menu = Menu::find($id);
        $menu->delete();
        toastr()->success(__('global.menu').__('global.deleted_success'),__('global.menu').__('global.deleted'));
        return redirect()->route('admin.menus.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $menu = Menu::withTrashed()->find($id);
        $menu->deleted_at = null;
        $menu->update();
        toastr()->success($menu->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.menus.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $menu = Menu::withTrashed()->find($id);
        $old_image_path = "uploads/".$menu->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $menu->forceDelete();
        toastr()->success(__('global.menu').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.menus.trashed');
    }
}
