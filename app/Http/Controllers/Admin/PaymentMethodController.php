<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class PaymentMethodController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $payment_methods = PaymentMethod::orderBy('id','DESC')->get();
        return view('admin.payment-methods.index',compact('payment_methods'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $payment_methods = PaymentMethod::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.payment-methods.trashed',compact('payment_methods'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.payment-methods.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'account_no' => 'required',
            'charge' => 'required|numeric',
            'status' => 'required',
        ]);

        $payment_method = PaymentMethod::create([
            'name' =>$request->name,
            'account_no' =>$request->account_no,
            'charge' =>$request->charge,
            'status' =>$request->status,
            'description' =>$request->description,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success($payment_method->name.__('global.created_success'),__('global.payment_method').__('global.created'));
        return redirect()->route('admin.payment-methods.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $payment_method = PaymentMethod::find($id);
        return view('admin.payment-methods.show',compact('payment_method'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $payment_method = PaymentMethod::find($id);
        return view('admin.payment-methods.edit',compact(['payment_method']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $payment_method = PaymentMethod::find($id);
        $request->validate([
            'name' => 'required',
            'account_no' => 'required',
            'charge' => 'required|numeric',
            'status' => 'required',
        ]);

        $payment_method->name = $request->name;
        $payment_method->account_no = $request->account_no;
        $payment_method->charge = $request->charge;
        $payment_method->status = $request->status;
        $payment_method->description = $request->description;
        $payment_method->updated_by = auth()->user()->id;

        $payment_method->update();
        toastr()->success($payment_method->name.__('global.updated_success'),__('global.payment_method').__('global.updated'));
        return redirect()->route('admin.payment-methods.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $payment_method = PaymentMethod::find($id);
        $payment_method->delete();
        toastr()->success(__('global.payment_method').__('global.deleted_success'),__('global.payment_method').__('global.deleted'));
        return redirect()->route('admin.payment-methods.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $payment_method = PaymentMethod::withTrashed()->find($id);
        $payment_method->deleted_at = null;
        $payment_method->update();
        toastr()->success($payment_method->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.payment-methods.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $payment_method = PaymentMethod::withTrashed()->find($id);
        $old_image_path = "uploads/".$payment_method->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $payment_method->forceDelete();
        toastr()->success(__('global.payment_method').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.payment-methods.trashed');
    }
}
