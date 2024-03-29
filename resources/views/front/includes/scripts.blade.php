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
                '<div class="col-2 text-lg-end text-start text-md-end col-md-2 p-0">' +
                '<span class="fw-bold">{{getSetting('currency')}}'+ item.total +'</span>' +
                '</div>' +
                '</div>' +
                '</li>';

            $('.cart-list').append(cartRow);

        });
        $('.cart-list').append('<div class="text-end fw-bold mt-2 px-3">Sub Total : {{getSetting('currency')}}<span class="product_sub_total">'+subtotal+'</span></div>');
        $('.cart-button').append(' <div class="d-flex justify-content-between mt-4">' +
            '<a href="{{route('products')}}" class="btn btn-{{getSetting('theme_color')}}">Continue Shopping</a>' +
            '<a href="{{route('checkout')}}" class="btn btn-danger">Checkout</a>' +
            '</div>');
        updateTotalwithDeliveryCharge();
        paymentMethodInfo();
    }

    function removeFromCart(productId){
        $.ajax({
            type: 'DELETE',
            url: '/cart/remove',
            data: { product_id: productId },
            success: function(response) {
                Swal.fire({
                    title: 'Removed!',
                    text: response.message,
                    icon: response.status,
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
                    icon: response.status,

                })
                getCartInfo()

            }
        });
    }
    function updateTotalwithDeliveryCharge() {

        var selectedOption = $('#delivery_zone_id :selected');
        var charge = parseFloat(selectedOption.data('charge')) || 0;
        var subtotal = parseFloat($('.product_sub_total:first').html());
        var discount = parseFloat($('#discount_amount').text())|| 0;
        var totalAmount = subtotal + charge;

        $('#delivery_charge').text(charge);
        $('#total_amount').text(totalAmount - discount);


    }
    function paymentMethodInfo() {
         var id = $('#payment_method_id').val();
        $('#payment_description').text('');
         if (id === 'cod' || id === ''){
             $('#payment_details').removeClass('d-block');
             $('#payment_details').addClass('d-none');
             var subtotal = parseFloat($('.product_sub_total').html());
             var charge = parseFloat($('#delivery_charge').text());
             var totalAmount = subtotal + charge ;
             $('#total_amount').text(totalAmount);
             $('#discount_amount').text(0)
         }else {
             $('#payment_details').removeClass('d-none')
             $('#payment_details').addClass('d-block')
             $.ajax({
                 type: 'POST',
                 url: '/payment-method',
                 data: { id: id },
                 success: function(response) {
                     $('#payment_description').text(response.message);


                     var subtotal = parseFloat($('.product_sub_total:last').html());
                     var charge = parseFloat($('#delivery_charge').text());

                     var discount_rate = parseFloat('{{getSetting('payment_discount')}}'); // Parse as a float
                     var max_discount = parseFloat('{{getSetting('payment_max_discount')}}'); // Parse as a float
                     var discount = (discount_rate / 100) * subtotal;
                     var totalAmount = subtotal+charge;

                     if (discount > max_discount){
                         discount = max_discount;
                     }
                     $('#discount_amount').text(discount)
                     $('#total_amount').text(totalAmount-discount);

                 }
             });
         }

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
                    icon: response.status,

                })
                getCartInfo()
                updateTotalwithDeliveryCharge()
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
        getCartInfo();
        updateTotalwithDeliveryCharge();
        paymentMethodInfo();

        // Listen for changes in the select element
        $('#delivery_zone_id').on('change', function () {
            updateTotalwithDeliveryCharge();
        });
        $('#payment_method_id').on('change', function () {
            paymentMethodInfo();
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
                        icon: response.status,

                    })
                    getCartInfo();

                }
            });
        });



        var phoneInput = $('#phone');
        var validationMessage = $('#validationMessage');
        var pattern = /^(?:\+8801|8801|01)([3456789]\d{8})$/;
        function validatePhoneNumber() {
            var phoneNumber = phoneInput.val();
            if (pattern.test(phoneNumber)) {
                validationMessage.text('Valid Bangladeshi phone number').css('color', 'green');
            } else {
                validationMessage.text('Invalid Bangladeshi phone number').css('color', 'red');
            }
        }
        phoneInput.on('input', validatePhoneNumber);
    });


</script>

