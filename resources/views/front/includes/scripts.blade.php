<script>
    function getCartInfo() {
        $.ajax({
            type: 'GET',
            url: '/cart/get',
            success: function(response) {
                if (response.totalItemCount > 0 ) {
                    $('.cart-empty').addClass('d-none')
                    $('.cart-empty').removeClass('d-block')
                    $('.checkout').addClass('d-block')
                    $('.checkout').removeClass('d-none')
                    $('.cart-count').text(response.totalItemCount)
                    updateCartInfo(response.cartList, response.totalItemCount, response.subtotal)
                } else {
                    $('.cart-empty').addClass('d-block')
                    $('.cart-empty').removeClass('d-none')
                    $('.checkout').addClass('d-none')
                    $('.checkout').removeClass('d-block')
                    $('.cart-list').html('');
                    $('.checkout').html('');
                    $('.cart-button').html('');
                    $('.cart-list').html('Cart is empty');
                    $('.cart-count').text(0)
                }
            },
            error: function(xhr, status, error) {
                console.log('Status :'+status+', Error: '+error+', xhr:'+xhr)
            }
        });
    }
    function updateCartInfo(cartList, totalItemCount, subtotal) {
        // Update your HTML elements or template here to display the cart information
        // Example: Update a cart table, total count, and subtotal
        $('.cart-list').html('');
        $('.cart-button').html('');
        // Loop through the cartList and append each item to the cart table
        cartList.forEach(function(item) {
            // Customize this based on your HTML structure

            var cartRow = '<li class="list-group-item py-3 ps-0">' +
                '<div class="row align-items-center">' +
                '<div class="col-5 col-md-6">' +
                '<div class="d-flex">' +
                '<img src="'+ item.image +'" alt="" class="icon-shape icon-md">' +
                '<div class="ms-3">' +
                '<a href="'+ item.url +'" class="text-inherit">' +
                '<h6 class="mb-0">'+ item.name +'</h6>' +
                '</a>' +
                '<span><small class="text-muted">{{getSetting('currency')}}'+ item.price +'</small></span>' +
                '<div class="mt-2 small lh-1">' +
                ' <a role="button" onclick="removeFromCart(' + item.product_id + ')" class="text-decoration-none text-inherit">Remove</a>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-5 col-md-4 ">' +
                '<div class="input-group input-spinner  ">' +
                '<input type="button" value="-" class="button-minus  btn  btn-sm " onclick="minusFromCart(' + item.product_id + ')" data-field="quantity">' +
                '<input type="text" disabled step="1" max="10" value="'+ item.quantity +'" name="quantity" class="quantity-field form-control-sm form-input   ">' +
                '<button type="button" class="button-plus btn btn-sm " onclick="addToCart(' + item.product_id + ')" data-field="quantity">+</button>' +
                '</div>' +
                '</div>' +
                '<div class="col-2 text-lg-end text-start text-md-end col-md-2">' +
                '<span class="fw-bold">{{getSetting('currency')}}'+ item.total +'</span>' +
                '</div>' +
                '</div>' +
                '</li>';

            $('.cart-list').append(cartRow);

        });
        $('.cart-list').append('<div class="text-end fw-bold mt-2 px-3">Sub Total : {{getSetting('currency')}}'+subtotal+'</div>');
        $('.cart-button').append(' <div class="d-flex justify-content-between mt-4">' +
            '<a href="{{route('products')}}" class="btn btn-primary">Continue Shopping</a>' +
            '<a href="{{route('checkout')}}" class="btn btn-danger">Checkout</a>' +
            '</div>');
    }

    function removeFromCart(productId){
        $.ajax({
            type: 'DELETE',
            url: '/cart/remove',
            data: { product_id: productId },
            success: function(response) {
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error',
                })
                getCartInfo()
            }
        });
    }
    function minusFromCart(productId){
        $.ajax({
            type: 'DELETE',
            url: '/cart/minus',
            data: { product_id: productId },
            success: function(response) {

                getCartInfo()
            }
        });
    }
    function addToCart(productId){
        $.ajax({
            type: 'POST',
            url: '/cart/add',
            data: { product_id: productId },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',

                })
                getCartInfo()
            }
        });
    }
    function orderNow(productId){
        $.ajax({
            type: 'POST',
            url: '/cart/add',
            data: { product_id: productId },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',

                })
                getCartInfo()
                window.location.replace("{{route('checkout')}}");
            }
        });
    }

    $(document).ready(function() {
        // Include the CSRF token in the AJAX request headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Add to Cart
        $('.add-to-cart').click(function() {
            var productId = $(this).data('product-id');
            $.ajax({
                type: 'POST',
                url: '/cart/add',
                data: { product_id: productId },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',

                    })
                    getCartInfo()
                }
            });
        });
        getCartInfo()
    });


</script>
