<script>
    $(document).ready(function() {
        $('#quickAddToCartModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageSrc = button.data('image');
            var price = '{{ $currency }}' + button.data('price');
            var maxQuantity = button.data('stock');

            var productId = button.data('product-id');
            var offerId = button.data('offer-id');

            var colors = button.data('colors');
            var sizes = button.data('sizes');
            
            var modal = $(this);
            modal.find('#modalProductImage').attr('src', imageSrc);
            modal.find('#productPrice').text(price);
            modal.find('#qty').attr('max', maxQuantity);

            var colorForm = modal.find('#colorForm');
            colorForm.empty();
            colors.forEach(function(color, index) {
                colorForm.append(`
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-${index}" name="color" value="${color}">
                        <label class="custom-control-label" for="color-${index}">${color}</label>
                    </div>
                `);
            });

            var sizeForm = modal.find('#sizeForm');
            sizeForm.empty();
            sizes.forEach(function(size, index) {
                sizeForm.append(`
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="size-${index}" name="size" value="${size}">
                        <label class="custom-control-label" for="size-${index}">${size}</label>
                    </div>
                `);
            });

            modal.find('.add-to-cart').attr({
                'data-product-id': productId,
                'data-price': button.data('price'),
                'data-offer-id': offerId,
            });
        });

        $('#quickAddToCartModal').on('hide.bs.modal', function() {
            var modal = $(this);
            
            modal.find('#modalProductImage').attr('src', '');
            modal.find('#productPrice').text('');
            modal.find('#qty').val(1).attr('max', '');

            modal.find('input[type="radio"]').prop('checked', false);

            modal.find('.add-to-cart').attr({
                'data-product-id': '',
                'data-price': '',
                'data-offer-id': '',
            });

            modal.find('.modal-body').find('select').val('').trigger('change');
        });
    });
</script>