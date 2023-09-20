<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
        <div class="text-start">
            <h5 id="offcanvasRightLabel" class="mb-0 fs-4">Shop Cart</h5>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="">
            <!-- alert -->
            <ul class="list-group list-group-flush">
                <!-- list group -->
                <li class="list-group-item py-3 ps-0">
                    <!-- row -->
                    <div class="row align-items-center">

                        <div class="col-5 col-md-6">
                            <div class="d-flex">
                                <img src="{{ asset('front') }}/images/products/product-img-1.jpg" alt="Ecommerce"
                                     class="icon-shape icon-xxl">
                                <div class="ms-3">
                                    <!-- title -->
                                    <a href="pages/shop-single.html" class="text-inherit">
                                        <h6 class="mb-0">Haldiram's Sev Bhujia</h6>
                                    </a>
                                    <span><small class="text-muted">.98 / lb</small></span>
                                    <!-- text -->
                                    <div class="mt-2 small lh-1"> <a href="#!"
                                                                     class="text-decoration-none text-inherit"> <span
                                                class="me-1 align-text-bottom">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                         height="14" viewBox="0 0 24 24" fill="none"
                                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                         stroke-linejoin="round"
                                                         class="feather feather-trash-2 text-success">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10"
                                                              y2="17"></line>
                                                        <line x1="14" y1="11" x2="14"
                                                              y2="17"></line>
                                                    </svg></span><span class="text-muted">Remove</span></a></div>
                                </div>
                            </div>
                        </div>
                        <!-- input group -->
                        <div class="col-5 col-md-4 ">
                            <!-- input -->
                            <!-- input -->
                            <div class="input-group input-spinner  ">
                                <input type="button" value="-" class="button-minus  btn  btn-sm "
                                       data-field="quantity">
                                <input type="number" step="1" max="10" value="1"
                                       name="quantity" class="quantity-field form-control-sm form-input   ">
                                <input type="button" value="+" class="button-plus btn btn-sm "
                                       data-field="quantity">
                            </div>

                        </div>
                        <!-- price -->
                        <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                            <span class="fw-bold">$5.00</span>

                        </div>
                    </div>

                </li>
            </ul>
            <!-- btn -->
            <div class="d-flex justify-content-between mt-4">
                <a href="#!" class="btn btn-primary">Continue Shopping</a>
                <a href="#!" class="btn btn-danger">Checkout</a>
            </div>

        </div>
    </div>
</div>
