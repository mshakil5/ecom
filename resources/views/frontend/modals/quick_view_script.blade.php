<script>
    $(document).ready(function () {
        $('.quick-view').on('click', function () {

            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productDescription = $(this).data('product-description');
            var productPrice = $(this).data('price');
            var productImage = $(this).data('image');
            var productColors = $(this).data('colors');
            var productSizes = $(this).data('sizes');

            $('#modal-product-name').text(productName);
            $('#modal-product-description').text(productDescription);
            $('#modal-product-price').html(`$${productPrice}`);
            $('#modal-product-image').attr('src', productImage);

            var colorsHtml = '';
            $.each(productColors, function (index, color) {
                colorsHtml += `<label>
                    <input name="modal-product-color" class="color-select" type="radio">
                    <span style="background-color: ${color}; width: 20px; height: 20px; display: inline-block; border: 1px solid #000;"></span>
                </label>`;
            });
            $('#modal-product-colors').html(colorsHtml);

            $('#modalQuickview').modal('show');
        });
    });
</script>