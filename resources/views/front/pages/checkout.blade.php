@extends('layouts.front')
@section('content')
    <section class="mb-lg-14 mb-8 mt-8">
        <div class="container text-center cart-empty">
            <h2>কোন প্রোডাক্ট নেই</h2>
            <a href="{{route('products')}}" class="btn btn-success">প্রোডাক্ট বাছাই করুন</a>
        </div>
        <div class="container checkout">
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
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">আপনার নাম </label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="আপনার নাম ">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">আপনার মোবাইল নম্বর </label>
                                                    <input type="tel" id="phone" class="form-control" placeholder="আপনার মোবাইল নম্বর ">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address" class="form-label">আপনার সম্পূর্ণ ঠিকানা</label>
                                                    <textarea  id="address" class="form-control" name="address" placeholder="আপনার সম্পূর্ণ ঠিকানা"></textarea>
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
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
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
                                    <!-- list group item -->
                                    <li class="list-group-item px-4 py-3">
                                        <div class="row align-items-center">
                                            <div class="col-2 col-md-2">
                                                <img src="../assets/images/products/product-img-1.jpg" alt="Ecommerce" class="img-fluid"></div>
                                            <div class="col-5 col-md-5">
                                                <h6 class="mb-0">Haldiram's Sev Bhujia</h6>
                                                <span><small class="text-muted">.98 / lb</small></span>

                                            </div>
                                            <div class="col-2 col-md-2 text-center text-muted">
                                                <span>1</span>

                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                <span class="fw-bold">$5.00</span>

                                            </div>
                                        </div>
                                    </li>
                                    <!-- list group item -->
                                </ul>
                                <div class="card-footer cart-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
