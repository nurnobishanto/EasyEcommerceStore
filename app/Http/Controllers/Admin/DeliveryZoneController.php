<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DeliveryZoneController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $delivery_zones = DeliveryZone::orderBy('id','DESC')->get();
        return view('admin.delivery-zones.index',compact('delivery_zones'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $delivery_zones = DeliveryZone::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.delivery-zones.trashed',compact('delivery_zones'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.delivery-zones.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'charge' => 'required|numeric',
            'status' => 'required',
        ]);

        $delivery_zone = DeliveryZone::create([
            'name' =>$request->name,
            'charge' =>$request->charge,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
            'status' =>$request->status,
        ]);
        toastr()->success($delivery_zone->name.__('global.created_success'),__('global.delivery_zone').__('global.created'));
        return redirect()->route('admin.delivery-zones.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $delivery_zone = DeliveryZone::find($id);
        return view('admin.delivery-zones.show',compact('delivery_zone'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $delivery_zone = DeliveryZone::find($id);
        return view('admin.delivery-zones.edit',compact(['delivery_zone']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $delivery_zone = DeliveryZone::find($id);
        $request->validate([
            'name' => 'required',
            'charge' => 'required|numeric',
            'status' => 'required',
        ]);

        $delivery_zone->name = $request->name;
        $delivery_zone->charge = $request->charge;
        $delivery_zone->status = $request->status;
        $delivery_zone->updated_by = auth()->user()->id;

        $delivery_zone->update();
        toastr()->success($delivery_zone->name.__('global.updated_success'),__('global.delivery_zone').__('global.updated'));
        return redirect()->route('admin.delivery-zones.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $delivery_zone = DeliveryZone::find($id);
        $delivery_zone->delete();
        toastr()->success(__('global.delivery_zone').__('global.deleted_success'),__('global.delivery_zone').__('global.deleted'));
        return redirect()->route('admin.delivery-zones.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $delivery_zone = DeliveryZone::withTrashed()->find($id);
        $delivery_zone->deleted_at = null;
        $delivery_zone->update();
        toastr()->success($delivery_zone->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.delivery-zones.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $delivery_zone = DeliveryZone::withTrashed()->find($id);
        $old_image_path = "uploads/".$delivery_zone->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $delivery_zone->forceDelete();
        toastr()->success(__('global.delivery_zone').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.delivery-zones.trashed');
    }
}
