@extends('layouts.app-master')
@section('content')
<div class="py-5 rounded">
    <div class="card">
        <div class="card-body px-0 mx-0">
            <div class="row px-4 p-2 mb-3">
                <div class="col-md-6">
                    <h5 class="card-title fw-semibold">Manajemen Stok Produk</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Manajemen Stok Produk yang ada di <b>Koperasi Usaha Bersama</b>.</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="row">
                        <div class="col-md">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        </div>
                        <div class="col-md">
                            <button class="btn btn-primary dropdown-toggle fw-semibold" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Category
                            </button>
                            <ul class="dropdown-menu">
                                @foreach($category as $categories)
                                <li><a class="dropdown-item" href="#">{{$categories}}</a></li>
                                @endforeach
                            </ul>
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
                    <tbody>
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
function editProductStock(id) {
    $.get("{{ url('/product/product-stock-edit-import') }}/" + id, {}, function(data, status) {
        $("#imported-page").html(data);
        $("#exampleModal").modal('show');
    });
}

function updateProductStock(id){
    $.ajax({
        type: 'GET',
        url: '{{ url("/product/product-stock-update-import") }}/' + id,
        data: {
            product_stock: $('#product_stock_update').val(),
            date: $('#current_date').val(),
            price: $('#product_price_update').val(),
            type: 'in'
        },
        success: function(data){
            $("#exampleModal").modal('hide');
            window.location.reload();
        },
        error: function(err){
            console.log(err);
        }
    });
}
</script>
@endsection