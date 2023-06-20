@extends('layouts.app-master')
@section('content')
<div class="py-5 rounded">
    <div class="card">
        <div class="card-body px-0 mx-0">
            <div class="row px-4 p-2 mb-3">
                <div class="col-md-6">
                    <h5 class="card-title fw-semibold">Manajemen Stok Produk</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Manajemen Stok Produk yang ada di <b>Koperasi
                            Usaha Bersama</b>.</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="row">
                        <div class="col-md">
                            <input id="search_filter_product_stock" class="form-control me-2" type="search"
                                placeholder="Cari produk disini" aria-label="Search">
                        </div>
                        <div class="col-md">
                            <select id="category_filter_product_stock" class="form-control">
                                <option selected disabled>Kategori</option>
                                <option value="semua">Semua Produk</option>
                                @foreach($category as $categories)
                                <option value="{{ $categories }}" class="fw-semibold">{{ $categories }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mb-3 mt-0">

            <div class="row px-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kode Produk</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Stok / Pcs</th>
                            <th scope="col">Diupdate pada</th>
                            <th class="nowrap text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="filter_target">
                        @php
                        $i = 1;
                        @endphp
                        @foreach($product_list as $product)
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td>{{$product->product->product_code}}</td>
                            <td>{{$product->product->product_name}}</td>
                            <td>{{$product->qty}}</td>
                            <td>{{ ($product->created_at)->format('j F Y') }}</td>
                            <td class="nowrap">
                                <a onClick="editProductStock('{{ $product->product->product_id }}')"
                                    class="btn btn-warning fw-semibold">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Modal Edit Product -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product Stock</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="imported-page"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#category_filter_product_stock').change(function() {
        $.ajax({
            type: 'GET',
            url: '{{ url("/product/product-filter-category-product-stock") }}',
            data: {
                data: $(this).val()
            },
            success: function(data) {
                let num = 1;
                let result = JSON.parse(data);
                let results = result.map(function(item) {
                    var dates = moment(item.created_at).format('D MMMM YYYY');
                    return `
                    <tr>
                        <th scope="row">${num++}</th>
                        <td>${item.product.product_code}</td>
                        <td>${item.product.product_name}</td>
                        <td>${item.qty}</td>
                        <td>${dates}</td>
                        <td class="nowrap">
                            <a onClick="editProductStock('${item.product_id}')"
                                class="btn btn-warning fw-semibold">Edit</a>
                        </td>
                    </tr>
                    `
                });

                $('#filter_target').html(results);
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    $('#search_filter_product_stock').on('keyup', function() {
        $.ajax({
            type: 'GET',
            url: '{{ url("/product/product-filter-search-product-stock") }}',
            data: {
                data: $(this).val()
            },
            success: function(data) {
                let num = 1;
                let result = JSON.parse(data);
                let results = result.map(function(item) {
                    var dates = moment(item.created_at).format('D MMMM YYYY');
                    return `
                    <tr>
                        <th scope="row">${num++}</th>
                        <td>${item.product.product_code}</td>
                        <td>${item.product.product_name}</td>
                        <td>${item.qty}</td>
                        <td>${dates}</td>
                        <td class="nowrap">
                            <a onClick="editProductStock('${item.product_id}')"
                                class="btn btn-warning fw-semibold">Edit</a>
                        </td>
                    </tr>
                    `
                });

                $('#filter_target').html(results);
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
});

function editProductStock(id) {
    $.get("{{ url('/product/product-stock-edit-import') }}/" + id, {}, function(data, status) {
        $("#imported-page").html(data);
        $("#exampleModal").modal('show');
    });
}

function updateProductStock(id) {
    $.ajax({
        type: 'GET',
        url: '{{ url("/product/product-stock-update-import") }}/' + id,
        data: {
            product_stock: $('#product_stock_update').val(),
            date: $('#current_date').val(),
            price: $('#product_price_update').val(),
            type: 'in'
        },
        success: function(data) {
            $("#exampleModal").modal('hide');
            window.location.reload();
        },
        error: function(err) {
            console.log(err);
        }
    });
}
</script>
@endsection