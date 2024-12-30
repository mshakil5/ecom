<div class="modal fade" id="modalQuickview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col text-end">
                            <button type="button" class="close modal-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-details-gallery-area">
                                <div class="product-large-image modal-product-image-large">
                                    <div class="product-image-large-single">
                                        <img id="modal-product-image" class="img-fluid" src="" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-details-content-area">
                                <div class="product-details-text">
                                    <h4 class="title" id="modal-product-name"></h4>
                                    <div class="price" id="modal-product-price"></div>
                                    <p id="modal-product-description"></p>
                                </div>
                                <div class="product-details-variable">
                                    <div class="variable-single-item">
                                        <span>Color</span>
                                        <div id="modal-product-colors" class="product-variable-color"></div>
                                    </div>
                                    <div class="variable-single-item">
                                        <span>Quantity</span>
                                        <div class="product-variable-quantity">
                                            <input id="modal-product-quantity" min="1" max="100" value="1" type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="product-details-meta mb-20">
                                    <ul>
                                        <li><a href="#"><i class="icon-heart"></i>Add to wishlist</a></li>
                                        <li><a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i>Add To Cart</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>