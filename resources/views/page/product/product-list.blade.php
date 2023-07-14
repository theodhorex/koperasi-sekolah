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
                                @if(Auth::user() -> role == 'Admin')
                                <div class="col-md">
                                    <button type="button" class="btn btn-primary fw-semibold w-100"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Tambah Produk
                                    </button>
                                </div>
                                @endif
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
                            <th scope="col" class="@if(Auth::user() -> role != 'admin')nowrap @endif">Ditambahkan pada</th>
                            @if(Auth::user() -> role == 'admin')
                            <th class="nowrap text-center" scope="col">Aksi</th>
                            @endif
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
                                @if(Auth::user() -> role == 'admin')
                                <td class="nowrap">
                                    <a onClick="editProduct('{{ $product->product_id }}')"
                                        class="btn btn-warning fw-semibold">Edit</a>
                                    <a onClick="deleteProduct('{{ $product->product_id }}')"
                                        class="btn btn-danger fw-semibold">Hapus</a>
                                </td>
                                @endif
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
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Product Category" name="product_category"
                        id="product_category" required="required" autofocus>
                    <label for="floatingName">Kategori Produk</label>
                </div>
                <div class="form-group form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Product Name" name="product_name"
                        id="product_name" required="required" autofocus>
                    <label for="floatingName">Nama Produk</label>
                </div>
                <div class="form-group form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Product Price" name="product_price"
                        id="product_price" required="required" autofocus>
                    <label for="floatingName">Harga</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" onClick="addProduct()">Tambah Produk</button>
            </div>
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

// Add Product
function addProduct() {
    $.ajax({
        type: 'GET',
        url: '{{ url("/product/product-add") }}',
        data: {
            product_category: $('#product_category').val(),
            product_name: $('#product_name').val(),
            product_price: parseInt($('#product_price').val())
        },
        success: function(data) {
            $("#exampleModal").modal('hide');
            Swal.fire({
                title: 'Data produk berhasil ditambahkan!',
                text: "Data berhasil ditambahkan!",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tutup',
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
            Swal.fire({
                title: 'Data produk berhasil diperbarui!',
                text: "Data berhasil diperbarui!",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tutup',
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

// Delete Product
function deleteProduct(id) {
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Produk ini akan dihapus secara permanen dari dalam database!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#cb0c9f',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Produk berhasil dihapus!',
                text: "Produk berhasil dihapus dari database!",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tutup',
                cancelButtonText: 'No'
            }).then(() => {
                url = "/product/product-delete/" + id;
                window.location.href = url;
            });
        }
    })
}
</script>
@endsection