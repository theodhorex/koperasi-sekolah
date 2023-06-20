@extends('layouts.app-master')
@section('content')
<div class="py-5 rounded">
    <div class="card">
        <div class="card-body px-0 mx-0">
            <div class="row px-4 p-2 mb-3">
                <div class="col-md-6">
                    <h5 class="card-title fw-semibold">Daftar Produk</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Daftar produk yang sudah ada di <b>Koperasi Usaha
                            Bersama</b>.</h6>
                </div>
                <div class="col-md-6">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-md">
                            <input id="search_filter_product_list" class="form-control me-2" type="search"
                                placeholder="Cari Produk disini" aria-label="Search">
                        </div>
                        <div class="col-md">
                            <div class="row">
                                <div class="col-md">
                                    <div class="dropdown">
                                        <select id="category_filter_product_list" class="form-control">
                                            <option selected disabled>Kategori</option>
                                            <option value="semua">Semua Produk</option>
                                            @foreach($category as $categories)
                                            <option value="{{ $categories }}" class="fw-semibold">{{ $categories }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <button type="button" class="btn btn-primary fw-semibold w-100"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Tambah Produk
                                    </button>

                                </div>
                            </div>
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
                            <th scope="col">Harga</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th class="nowrap text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="filter_target">
                        <div class="filter_target_body">
                            @php
                            $i = 1;
                            @endphp
                            @foreach($product_list as $product)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>Rp. {{ number_format($product->price, 2, ',', '.') }}</td>
                                <td>{{ ($product->created_at)->format('j F Y') }}</td>
                                <td class="nowrap">
                                    <a onClick="editProduct('{{ $product->product_id }}')"
                                        class="btn btn-warning fw-semibold">Edit</a>
                                    <a onClick="deleteProduct('{{ $product->product_id }}')"
                                        class="btn btn-danger fw-semibold">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Add Product -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('product.product-add') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Product Category" name="product_category"
                            required="required" autofocus>
                        <label for="floatingName">Product Category</label>
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Product Name" name="product_name"
                            required="required" autofocus>
                        <label for="floatingName">Product Name</label>
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input type="number" class="form-control" placeholder="Product Price" name="product_price"
                            required="required" autofocus>
                        <label for="floatingName">Price</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Product -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel2">Edit Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="imported-page"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Category filter
    $('#category_filter_product_list').change(function() {
        $.ajax({
            type: 'GET',
            url: '{{ url("/product/product-filer-category-product-list") }}',
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
                        <td>${item.product_code}</td>
                        <td>${item.product_name}</td>
                        <td>Rp. ${(item.price / 1000).toFixed(3) + ',' + '00'}</td>
                        <td>${dates}</td>
                        <td class="nowrap">
                            <a onClick="editProduct('${item.product_id}')"
                                class="btn btn-warning fw-semibold">Edit</a>
                            <a onClick="deleteProduct('${item.product_id}')"
                                class="btn btn-danger fw-semibold">Hapus</a>
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

    // Search filter
    $('#search_filter_product_list').on('keyup', function() {
        $.ajax({
            type: 'GET',
            url: '{{ url("/product/product-search-filter-product-list") }}',
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
                        <td>${item.product_code}</td>
                        <td>${item.product_name}</td>
                        <td>Rp. ${(item.price / 1000).toFixed(3) + ',' + '00'}</td>
                        <td>${dates}</td>
                        <td class="nowrap">
                            <a onClick="editProduct('${item.product_id}')"
                                class="btn btn-warning fw-semibold">Edit</a>
                            <a onClick="deleteProduct('${item.product_id}')"
                                class="btn btn-danger fw-semibold">Hapus</a>
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

// Other Function

// Edit Product
function editProduct(id) {
    $.get("{{ url('/product/product-edit') }}/" + id, {}, function(data, status) {
        $("#imported-page").html(data);
        $("#exampleModal2").modal('show');
    });
}

function updateProduct(id) {
    $.ajax({
        type: 'GET',
        url: '{{ url("/product/product-update") }}/' + id,
        data: {
            product_category: $('#product_category_update').val(),
            product_category_code: $('#product_category_code').val(),
            product_name: $('#product_name_update').val(),
            product_price: $('#product_price_update').val()
        },
        success: function(data) {
            $("#exampleModal2").modal('hide');
            window.location.reload();
        },
        error: function(err) {
            console.log(err);
        }
    });
}

// Delete Product
function deleteProduct(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This product will be deleted permanently from your database!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#cb0c9f',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            url = "/product/product-delete/" + id;
            window.location.href = url;
        }
    })
}
</script>
@endsection