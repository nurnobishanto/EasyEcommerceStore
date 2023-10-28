<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IpBlock;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IpBlockController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $ip_blocks = IpBlock::orderBy('id','DESC')->get();
        return view('admin.ip_blocks.index',compact('ip_blocks'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $ip_blocks = IpBlock::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.ip_blocks.trashed',compact('ip_blocks'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.ip_blocks.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'ip_address' => 'required|unique:ip_blocks',
            'status' => 'required',
        ]);

        $ip_block = IpBlock::create([
            'ip_address' =>$request->ip_address,
            'status' =>$request->status,
        ]);
        toastr()->success($ip_block->name.__('global.created_success'),__('global.ip_block').__('global.created'));
        return redirect()->route('admin.ip-blocks.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $ip_block = IpBlock::find($id);
        return view('admin.ip_blocks.show',compact('ip_block'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $ip_block = IpBlock::find($id);
        return view('admin.ip_blocks.edit',compact(['ip_block']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $ip_block = IpBlock::find($id);
        $request->validate([
            'ip_address' => 'required|unique:ip_blocks,id,'.$id,
            'status' => 'required',
        ]);


        $ip_block->ip_address = $request->ip_address;
        $ip_block->status = $request->status;
        $ip_block->update();
        toastr()->success($ip_block->name.__('global.updated_success'),__('global.ip_block').__('global.updated'));
        return redirect()->route('admin.ip-blocks.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $ip_block = IpBlock::find($id);
        $ip_block->delete();
        toastr()->success(__('global.ip_block').__('global.deleted_success'),__('global.ip_block').__('global.deleted'));
        return redirect()->route('admin.ip-blocks.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $ip_block = IpBlock::withTrashed()->find($id);
        $ip_block->deleted_at = null;
        $ip_block->update();
        toastr()->success($ip_block->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.ip-blocks.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $ip_block = IpBlock::withTrashed()->find($id);
        $ip_block->forceDelete();
        toastr()->success(__('global.ip_block').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.ip-blocks.trashed');
    }
    public function block($id){
        $order = Order::find($id);
        if ($order->ip_address){
            $ip = IpBlock::where('ip_address',$order->ip_address)->first();
            if ($ip){
                $ip->status = 'active';
                $ip->update();
            }else{
                IpBlock::create([
                    'ip_address' => $order->ip_address,
                    'status' => 'active',
                ]);
            }
        }
        toastr()->success('IP Blocked');
        return redirect()->back();
    }
    public function unblock($id){
        $order = Order::find($id);
        if ($order->ip_address){
            $ip = IpBlock::where('ip_address',$order->ip_address)->first();
            if ($ip){
                $ip->status = 'deactivate';
                $ip->update();
            }
        }
        toastr()->success('IP Unblocked');
        return redirect()->back();
    }
}
