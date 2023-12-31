<div class="modal-body">
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" placeholder="Kategori Produk" id="product_category_update"
            required="required" value="{{ $i[0] }}" autofocus>
        <label for="floatingName">Kategori Produk</label>
        <input type="hidden" id="product_category_code" value="{{ $i[1] }}">
    </div>
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" placeholder="Nama Produk" id="product_name_update" required="required"
            value="{{ $product->product_name }}" autofocus>
        <label for="floatingName">Nama Produk</label>
    </div>
    <div class="form-group form-floating mb-3">
        <input type="number" class="form-control" placeholder="Harga Produk" id="product_price_update" required="required"
            value="{{ $product->price }}" autofocus>
        <label for="floatingName">Harga</label>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    <button onClick="updateProduct('{{ $product->product_id }}')" class="btn btn-primary">Update Produk</button>
</div>