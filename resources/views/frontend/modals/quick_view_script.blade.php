<script>
    $(document).ready(function () {
        $('.quick-view').on('click', function () {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productDescription = $(this).data('product-description');
            var productPrice = $(this).data('price');
            var productImage = $(this).data('image');
            var productColors = JSON.parse($(this).attr('data-colors'));
            var productStock = $(this).data('stock');

            $('#modal-product-name').text(productName);
            $('#modal-product-description').text(productDescription);
            $('#modal-product-price').html(productPrice);
            $('#modal-product-quantity').attr('max', productStock);

            $('#modal-product-image').attr('src', productImage);

            var colorOptionsHtml = '';
            productColors.forEach(function (color) {
                var colorId = `modal-product-color-${color.toLowerCase()}`;
                colorOptionsHtml += `
                    <label for="${colorId}">
                        <input name="modal-product-color" id="${colorId}" class="color-select" type="radio">
                        <span class="product-color-${color.toLowerCase()}"></span>
                    </label>
                `;
            });
            $('#modal-product-colors').html(colorOptionsHtml);

            $('#modalQuickview').modal('show');
        });
    });
</script>