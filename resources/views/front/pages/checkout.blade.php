@extends('layouts.front')
@section('content')
    <section class="mb-lg-14 mb-8 mt-8">
        <div class="container text-center cart-empty d-none">
            <h2>কোন প্রোডাক্ট নেই</h2>
            <a href="{{route('products')}}" class="btn btn-success">প্রোডাক্ট বাছাই করুন</a>
        </div>
        <div class="container checkout d-none">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="mb-8">
                            <h1 class="fw-bold mb-0">Checkout</h1>
                            <p class="mb-0">অর্ডারটি কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার, লিখে অর্ডার কনফার্ম করুন বাটনে ক্লিক করুন </p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item py-4">
                                <div class="card card-bordered shadow-none mb-2">
                                    <div class="card-header">
                                        <h5 class="card-title">Order Information</h5>
                                    </div>
                                    <div class="card-body p-6">
                                        <form action="{{route('orderConfirm')}}" method="post">
                                            @csrf
                                            <div class="row g-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">আপনার নাম </label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="আপনার নাম ">
                                                    @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">আপনার মোবাইল নম্বর </label>
                                                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="আপনার মোবাইল নম্বর ">
                                                    <p id="validationMessage"></p>
                                                    @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address" class="form-label">আপনার সম্পূর্ণ ঠিকানা</label>
                                                    <textarea  id="address" class="form-control" name="address" placeholder="আপনার সম্পূর্ণ ঠিকানা"></textarea>
                                                    @error('address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="order_note" class="form-label">Order Note</label>
                                                    <textarea  id="order_note" class="form-control" name="order_note" placeholder="Order Note"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="delivery_zone_id" class="form-label">Delivery Zone</label>
                                                    <select id="delivery_zone_id" class="form-control" name="delivery_zone_id" >
                                                        <option value="">Select Delivery Zone</option>
                                                        @foreach(deliveryZones() as $zone)
                                                            <option onclick="updateTotalwithDeliveryCharge()" value="{{$zone->id}}" data-charge="{{$zone->charge}}">{{$zone->name}} - {{getSetting('currency')}}{{$zone->charge}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('delivery_zone_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-danger" value="অর্ডার কনফার্ম করুন">

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="mt-4 mt-lg-0">
                            <div class="card shadow-sm">
                                <h5 class="px-6 py-4 bg-transparent mb-0">Order Details</h5>
                                <ul class="list-group list-group-flush cart-list px-2">

                                </ul>
                                <div class="card-footer cart-footer">
                                    <p class="text-end">Delivery Charge : + {{getSetting('currency')}}<span class="delivery_charge">80</span></p>
                                    <p class="text-end fw-bold">Total :  {{getSetting('currency')}}<span class="total_amount"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

