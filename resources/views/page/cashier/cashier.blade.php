@extends('layouts.app-master')
@section('content')
<div class="py-5 rounded">
    <div class="row">
        <div class="col-md-8 pe-5">
            <h4 class="fw-semibold d-inline-flex mb-0">Produk</h4>
            <hr>
            @foreach($product as $products)
            <div class="row p-2">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @php
                                $category = explode('-', $products->product->product_code)[0];
                                @endphp
                                <h5 class="card-title fw-semibold mb-0">{{ $category }} -
                                    {{ $products->product->product_name }}
                                </h5>
                            </div>
                            <div class="col">
                                <h5 class="mb-0 fw-semibold float-end">Rp.
                                    {{ number_format($products->product->price, 2, ',', '.') }}
                                    <span class="material-icons mb-0 ms-3 cursor-pointer float-end"
                                        onClick="getProductDetail('{{ $products->product_id }}')">
                                        playlist_add
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-4 shadow p-3 px-4 bg-body-tertiary rounded">
            <div class="row">
                <div class="col">
                    <h4 class="fw-semibold mb-0">Daftar Order</h4>
                </div>
                <div class="col">
                    <h4 class=" mb-0">
                        <span class="material-icons float-end text-secondary">
                            local_mall
                        </span>
                    </h4>
                </div>
            </div>
            <hr>
            <div id="shopping_cart_view">
                <h5 class="fw-semibold text-center my-5">Belum ada produk di keranjang</h5>
            </div>

            <hr>

            <!-- Total Price -->
            <div class="row">
                <div class="col">
                    <div class="mb-2">
                        <h5 id="orderListTotalItem" class="fw-semibold">Total Produk: 0</h5>
                        <!-- <h6 class="fw-semibold">4</h6> -->
                    </div>
                    <div class="mb-2">
                        <h5 id="orderListSubtotalPrice" class="fw-semibold">Subtotal: 0</h5>
                        <!-- <h6 class="fw-semibold">Rp. 400.000,00</h6> -->
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input type="number" id="amountOrderPrice" class="form-control fw-semibold"
                            placeholder="Enter Payment" required="required">
                        <label for="floatingName">Jumlah Pembayaran</label>
                    </div>
                    <hr>
                    <div class="row px-2">
                        <a onClick="purchaseOrder()" class="btn btn-primary p-2 fw-semibold">Konfirmasi Pembayaran Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Product Info -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header px-4">
                <h1 class="modal-title fs-5" id="modal_title">Product name - Product Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <h5 class="mb-0">Nama Produk: <b id="product_name">Sunspot</b></h5>
                <h5 class="mb-0">Kategori Produk: <b id="product_category">ATK</b></h5>
                <h5>Stok Produk: <b id="product_stock">50 Pcs</b></h5>
                <h5>Harga: <b id="product_price">Rp. 50.000,00</b></h5>
                <hr>
                <div class="form-group form-floating mb-3">
                    <input type="number" id="purchase_amount" class="form-control fw-semibold"
                        placeholder="Enter the purchase amount" required="required">
                    <label for="floatingName">Masukan jumlah produk yang akan dibeli</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="addToCartButton" class="btn btn-primary fw-semibold">Tambah ke keranjang</button>
            </div>
        </div>
    </div>
</div>




<script>
let shoppingCart = [];
let subtotal = [];

$(document).ready(function() {

    $('#addToCartButton').click(function() {
        let product_id = $(this).val();
        let qty = parseInt($('#purchase_amount').val());

        $.ajax({
            type: 'GET',
            url: '{{ url("/cashier/cashier-get-product-detail-order") }}/' + product_id,
            success: function(data) {
                let product = JSON.parse(data)[0];
                let existingProductIndex = isProductInCart(product);

                if (existingProductIndex !== -1) {
                    shoppingCart[existingProductIndex].qty += qty;
                } else {
                    product.qty = qty;
                    shoppingCart.push(product);
                }

                console.log(shoppingCart);
                console.log('berhasil');

                function isProductInCart(product) {
                    for (let i = 0; i < shoppingCart.length; i++) {
                        if (shoppingCart[i].product_id === product.product_id) {
                            return i;
                        }
                    }
                    return -1;
                }

                renderShoppingCart();
            },
            error: function(err) {
                console.log(err);
            }
        });

        function renderShoppingCart() {
            $('#shopping_cart_view').empty();
            for (let i = 0; i < shoppingCart.length; i++) {
                let data = `
                    <div class="row mb-2">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h5 class="fw-semibold">${shoppingCart[i].product_name}</h5>
                                </div>
                                <div class="col">
                                    <h6 class="fw-semibold float-end">X ${shoppingCart[i].qty}</h6>
                                </div>
                            </div>
                            <h6>ATK</h6>
                            <h6>Rp. ${(shoppingCart[i].price / 1000).toFixed(3) + ',' + '00'}</h6>
                            <h6 class="fw-semibold">
                                => Rp. ${(shoppingCart[i].qty * shoppingCart[i].price / 1000).toFixed(3) + ',' + '00'}
                            </h6>
                        </div>
                    </div>
                `;
                $('#shopping_cart_view').append(data);
                $('#orderListTotalItem').html('Total Produk: ' + shoppingCart.length);

                calculateSubtotal();
            }
        }

        function calculateProductSubtotal(product) {
            return product.price * product.qty;
        }

        function calculateSubtotal() {
            let subtotal = 0;

            for (let i = 0; i < shoppingCart.length; i++) {
                subtotal += calculateProductSubtotal(shoppingCart[i]);
            }

            $('#orderListSubtotalPrice').html('Subtotal: Rp. ' + (subtotal / 1000).toFixed(3) + ',' +
                '00');
        }

        $("#exampleModal").modal('hide');
    });
});

function getProductDetail(id) {
    $.ajax({
        type: 'GET',
        url: '{{ url("/cashier/cashier-get-product-detail") }}/' + id,
        success: function(data) {
            var product = JSON.parse(data).product_detail[0];
            $('#product_name').html(product.product_name);
            $('#product_category').html(product.product_code.split('-')[0]);
            $('#product_price').html((product.price / 1000).toFixed(3) + ',' + '00');
            $('#product_stock').html(JSON.parse(data).product_stock[0].qty);
            $('#modal_title').html(product.product_name + ' ' + '-' + ' ' + product.product_code.split('-')[
                0]);
            $('#addToCartButton').val(product.product_id);
            $('#purchase_amount').val(0);
            $('#modal_title').addClass('fw-semibold');
            $("#exampleModal").modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    });
}

function purchaseOrder() {
    $.ajax({
        type: 'GET',
        url: '{{ url("/cashier/cashier-purchase-order") }}',
        data: {
            amount: $('#amountOrderPrice').val(),
            shoppingCart: shoppingCart
        },
        success: function(data) {
            Swal.fire({
                title: 'Order purchased successfully!',
                text: "Your order purchased successfully!",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then(() => {
                window.location.reload()
            });
        },
        error: function(err) {
            console.log(err);
        }
    });
}
</script>
@endsection