<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        App::setLocale(session('locale'));
        $orders = Order::orderBy('id','DESC')->get();
        if ($request->status){
            $orders = $orders->where('status',$request->status);
        }

        return view('admin.orders.index',compact('orders'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $orders = Order::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.orders.trashed',compact('orders'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $products = Product::all();
        $delivery_zones = DeliveryZone::all();
        return view('admin.orders.create',compact('products','delivery_zones'));
    }

    public function store(Request $request)
    {


        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'delivery_zone_id' => 'required',
        ]);

        $order = Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'order_note' => $request->order_note,
            'delivery_zone_id' => $request->delivery_zone_id,
            'paid_amount' => $request->paid_amount??0,
            'trxid' => $request->trxid,
            'discount_percent' => $request->discount_percent??0,
            'max_discount' => $request->max_discount??0.0,
            'status' => $request->status,
            'subtotal' => 0,
            'delivery_charge' => 0,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        if ($request->has('product_ids')) {
            $product_ids = $request->input('product_ids');
            $product_quantities = $request->input('product_quantities');
            $productsWithPivot = [];
            for ($i = 0 ;$i < sizeof($product_ids);$i++){
                $product = Product::find($product_ids[$i]);

                $quantity = $product_quantities[$i];
                $product->quantity = $product->quantity -$quantity;
                $product->update();
                $productsWithPivot[] = [
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'sub_total' => $quantity*$product->price,
                ];

            }
            DB::table('order_product')->insert($productsWithPivot);
        }

        $order->delivery_charge = $order->delivery_zone->charge;
        $orderSubTotal = 0;
        foreach ($order->products as $product) {
            $orderSubTotal += $product['pivot']['sub_total'];

        }

        $order->subtotal = $orderSubTotal;
        if ( $request->input('payment_method_id') ==='cod' || $request->input('payment_method_id') ===''){
        }else{
            $order->payment_method_id = $request->input('payment_method_id');
        }
        $order->update();
        toastr()->success($order->name.__('global.created_success'),__('global.order').__('global.created'));
        return redirect()->route('admin.orders.index');
    }
    public function show(string $id)
    {

        App::setLocale(session('locale'));
        $order = Order::find($id);
        return view('admin.orders.show',compact('order'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $order = Order::find($id);
        $products = Product::all();
        $delivery_zones = DeliveryZone::all();
        return view('admin.orders.edit',compact(['order','products','delivery_zones']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $order = Order::find($id);

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'delivery_zone_id' => 'required',
        ]);
        $zone = DeliveryZone::find($request->delivery_zone_id);


        // 1. Identify Removed Products
        $originalProductIds = $order->products->pluck('id')->toArray();
        $updatedProductIds = $request->input('product_ids');
        $removedProductIds = array_diff($originalProductIds, $updatedProductIds);

        // 2. Update Stock Quantities for Removed Products
        foreach ($removedProductIds as $productId) {
            $product = Product::find($productId);
            $quantityToRemove = $order->products->where('id', $productId)->first()['pivot']['quantity'];
            $product->quantity += $quantityToRemove;
            $product->update();
        }

        // 3. Handle Newly Added Products
        $updatedQuantities = $request->input('product_quantities');

        foreach ($updatedProductIds as $data=>$productId) {
            $product = Product::find($productId);
            $order_product =  $order->products->where('id',$productId);
            $quantityToAdd = $updatedQuantities[$data];

            if (sizeof($order_product)>0){
                $difference = $order_product[0]['pivot']['quantity'] - $updatedQuantities[$data];
                $product->quantity += $difference;
            }else{
                $product->quantity -= $quantityToAdd;
            }
            $product->update();
        }
        if ( $request->input('payment_method_id') ==='cod' || $request->input('payment_method_id') ===''){
        }else{
            $order->payment_method_id = $request->input('payment_method_id');
        }
        // 4. Update the Order
        $order->name = $request->input('name');
        $order->phone = $request->input('phone');
        $order->address = $request->input('address');
        $order->order_note = $request->input('order_note');
        $order->delivery_zone_id = $request->input('delivery_zone_id');
        $order->discount_percent = $request->input('discount_percent')??0.0;
        $order->max_discount = $request->input('max_discount')??0.0;
        $order->paid_amount = $request->input('paid_amount')??0.0;
        $order->trxid = $request->input('trxid');
        $order->updated_by = auth()->user()->id;

        // Handle selected products for update
        if ($request->has('product_ids')) {
            $productIds = $request->input('product_ids');
            $productQuantities = $request->input('product_quantities');
            $productsWithPivot = [];

            foreach ($productIds as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $productQuantities[$index];

                // Update the pivot data (if it already exists) or create it
                $pivotData = [
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'sub_total' => $quantity * $product->price,
                ];

                $order->products()->syncWithoutDetaching([$productId => $pivotData]);
            }
        }

        // Recalculate and update order totals
        $order->delivery_charge = $zone->charge;
        $orderSubTotal = $order->products->sum(function ($product) {
            return $product['pivot']['sub_total'];
        });
        $order->subtotal = $orderSubTotal;
        $order->update();

        toastr()->success($order->name.__('global.updated_success'),__('global.order').__('global.updated'));
        return redirect()->route('admin.orders.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $order = Order::find($id);
        $order->delete();
        toastr()->success(__('global.order').__('global.deleted_success'),__('global.order').__('global.deleted'));
        return redirect()->route('admin.orders.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $order = Order::withTrashed()->find($id);
        $order->deleted_at = null;
        $order->update();
        toastr()->success($order->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.orders.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $order = Order::withTrashed()->find($id);
        $old_image_path = "uploads/".$order->thumbnail;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $order->forceDelete();
        toastr()->success(__('global.order').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.orders.trashed');
    }

    public function order_status_update(Request $request,$id){
        $order = Order::find($id);
        $newStatus = $request->input('status');
        $updateQuantity = false;

        if (in_array($order->status, ['pending', 'received', 'delivered','completed']) && in_array($newStatus, ['rejected', 'canceled', 'stoke_out'])) {
            $updateQuantity = true;
        }elseif (in_array($order->status, ['rejected', 'canceled', 'stoke_out']) && in_array($newStatus, ['pending', 'received', 'delivered','completed'])){
            $updateQuantity = true;
        }
        $order->status = $newStatus;
        $order->save();


        // Update product quantity if necessary
        if ($updateQuantity) {
            foreach ($order->products as $product) {
                switch ($newStatus) {
                    case 'pending':
                    case 'success':
                    case 'received':
                    case 'delivered':
                    case 'completed':
                        $product->quantity -= $product->pivot->quantity;
                        break;

                    case 'canceled':
                    case 'rejected':
                    case 'stock_out':
                        $product->quantity += $product->pivot->quantity;
                        break;

                    default:

                        break;
                }

                // Save the product
                $product->save();
            }
        }
        toastr()->success(__('global.order').__('global.updated_success'),__('global.updated'));
        return redirect()->route('admin.orders.index');
    }
    public function order_print($id){
        $order = Order::find($id);
        $data = [
            'title' => getSetting('site_name').' Order Invoice',
            'date' => date('m/d/Y'),
            'order' => $order,
        ];

        $html = view('invoice', $data);
        return $html;
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfFileName = $order->order_id . '_invoice.pdf';
        $pdfPath = public_path('pdfs/' . $pdfFileName);
        $dompdf->stream($pdfFileName);

        return redirect(route('admin.orders.index'));
    }
}
