<footer class="footer">
    <div class="container">
        <div class="row g-4 py-4">
            <div class="col-12 col-md-12 col-lg-6">
                <h6 class="mb-4">About us</h6>
                <div class="row">
                    <div class="col-md-6">
                        <!-- list -->
                        @if(getSetting('site_logo'))
                      <img src="{{asset('uploads/'.getSetting('site_logo'))}}" class="img-fluid" style="max-height: 200px">
                        @endif
                        {!! getSetting('site_address') !!}
                    </div>
                    <div class="col-md-6">
                        {!! getSetting('site_description') !!}
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6">
                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-md-6">
                        <h6 class="mb-4">Get to know us</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="{{route('about')}}" class="nav-link">About Us</a></li>
                            <li class="nav-item mb-2"><a href="{{route('contact')}}" class="nav-link">Contact Us</a></li>
                            <li class="nav-item mb-2"><a href="{{route('terms')}}" class="nav-link">Terms & Conditions</a></li>
                            <li class="nav-item mb-2"><a href="{{route('privacy')}}" class="nav-link">Privacy Policy</a></li>
                            <li class="nav-item mb-2"><a href="{{route('return_policy')}}" class="nav-link">Return Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6">
                        <h6 class="mb-4">Important Links</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="{{route('products')}}" class="nav-link">All Products</a></li>
                            <li class="nav-item mb-2"><a href="{{route('categories')}}" class="nav-link">All Categories</a></li>
                            <li class="nav-item mb-2"><a href="{{route('new_products')}}" class="nav-link">New Products</a></li>
                            <li class="nav-item mb-2"><a href="{{route('track_order')}}" class="nav-link">Track Order</a></li>
                            <li class="nav-item mb-2"><a href="{{route('checkout')}}" class="nav-link">Checkout</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="border-top py-4">
            <div class="row align-items-center">
                <div class="col-lg-5 text-lg-start text-center mb-2 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item text-dark">Support Number</li>
                        <li class="list-inline-item">
                            <a href="tel:{{getSetting('support_number')}}">{{getSetting('support_number')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7 mt-4 mt-md-0">
                    <ul class="list-inline mb-0 text-lg-end text-center">
                        <li class="list-inline-item mb-2 mb-md-0 text-dark">Developed By <a href="https://soft-itbd.com">SOFT-ITBD.COM Smart IT Solution</a></li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="border-top py-4">
            <div class="row align-items-center">
                <div class="col-md-6"><span class="small text-muted">© 2022 <span id="copyright"> -
                                <script>
                                    document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                                </script>
                            </span>All rights reserved <a
                            href="{{route('home')}}">{{getSetting('site_name')}}</a>.</span></div>
                <div class="col-md-6">
                    <ul class="list-inline text-md-end mb-0 small mt-3 mt-md-0">
                        <li class="list-inline-item text-muted">Follow us on</li>
                        <li class="list-inline-item me-1">
                            <a href="{{getSetting('facebook')}}" class="btn btn-xs btn-social btn-icon"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                </svg></a>
                        </li>
                        <li class="list-inline-item me-1">
                            <a href="{{getSetting('youtube')}}" class="btn btn-xs btn-social btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-youtube"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{getSetting('instagram')}}" class="btn btn-xs btn-social btn-icon"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                </svg></a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>
