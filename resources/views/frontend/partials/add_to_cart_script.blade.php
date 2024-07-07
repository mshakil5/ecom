<script>
    $(document).ready(function() {
        function updateCartCount() {
            var cart = JSON.parse(localStorage.getItem('cart')) || [];
            var cartCount = cart.length;
            $('.cartCount').text(cartCount);
        }

        $('.add-to-cart').click(function(e) {
            e.preventDefault();

            var productId = $(this).data('product-id');
            var offerId = $(this).data('offer-id');
            var price = $(this).data('price');

            var selectedSize = $('input[name="size"]:checked').val() || 'M';
            var selectedColor = $('input[name="color"]:checked').val() || 'Black'; 
            var quantity = parseInt($('.quantity input').val()) || 1;

            var cart = JSON.parse(localStorage.getItem('cart')) || [];

            var existingItem = cart.find(function(item) {
                return item.productId === productId && item.size === selectedSize && item.color === selectedColor && item.offerId === offerId;
            });

            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                var cartItem = {
                    productId: productId,
                    offerId: offerId,
                    price: price,
                    size: selectedSize,
                    color: selectedColor,
                    quantity: quantity
                };
                cart.push(cartItem);
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            // console.log('Updated Cart:', cart);

            updateCartCount();

            swal({
                text: "Added to cart",
                icon: "success",
                button: {
                    text: "OK",
                    className: "swal-button--confirm"
                }
            });
        });

        $(document).on('click', '.remove-from-cart', function() {
            var cart = JSON.parse(localStorage.getItem('cart')) || [];
            var index = $(this).data('cart-index');

            if (index !== undefined) {
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                // console.log('Updated Cart:', cart);

                swal({
                    text: "Removed from cart",
                    icon: "success",
                    button: {
                        text: "OK",
                        className: "swal-button--confirm"
                    }
                });
                updateCartCount();
            }
        });

        $('.cartBtn').click(function(e) {
            e.preventDefault();
            var cart = JSON.parse(localStorage.getItem('cart')) || [];

            // console.log('Sending cart data:', cart);
            // localStorage.removeItem('cart');
            
            $.ajax({
                type: "POST",
                url: "{{ route('cart.index') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart: JSON.stringify(cart) 
                },
                success: function(response) {
                    $('body').html(response);
                    history.pushState({}, '', '{{ route('cart.index') }}');
                },
                error: function(response) {
                    // console.log('Error:', response);
                }
            });
        });

        $('.cartLink').click(function(e) {
            e.preventDefault();
            var cart = JSON.parse(localStorage.getItem('cart')) || [];
            // console.log('Sending cart data:', cart);
            // localStorage.removeItem('cart');
            
            $.ajax({
                type: "POST",
                url: "{{ route('cart.index') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart: JSON.stringify(cart) 
                },
                success: function(response) {
                    $('body').html(response);
                    history.pushState({}, '', '{{ route('cart.index') }}');
                },
                error: function(response) {
                    // console.log('Error:', response);
                }
            });
        });

        updateCartCount();
    });
</script>
