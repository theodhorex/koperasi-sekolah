<div class="modal-body">
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" placeholder="Product Code" id="product_code_update"
            required="required" value="{{ $get_data->product->product_code }}" autofocus readonly>
        <label for="floatingName">Kode Produk</label>
    </div>
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" placeholder="Product Name" id="product_name_update"
            required="required" value="{{ $get_data->product->product_name }}" autofocus readonly>
        <label for="floatingName">Nama Produk</label>
    </div>
    <div class="form-group form-floating mb-3">
        <input type="date" class="form-control" placeholder="Date" id="current_date"
        required="required" autofocus>
        <label for="floatingName">Tanggal</label>
    </div>
    <div class="form-group form-floating mb-3">
        <input type="number" class="form-control" placeholder="Product Stock" id="product_stock_update"
            required="required" value="{{ $get_data->qty }}" autofocus>
        <label for="floatingName">Stok</label>
    </div>
    <div class="form-group form-floating mb-3">
        <input type="number" class="form-control" placeholder="Product Price" id="product_price_update"
            required="required" autofocus>
        <label for="floatingName">Harga Produk</label>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    <button onClick="updateProductStock('{{ $get_data->product_id }}')" class="btn btn-primary">Simpan</button>
</div>