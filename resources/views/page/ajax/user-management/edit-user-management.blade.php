<div class="modal-body">
    <!-- Email -->
    <div class="form-group form-floating mb-3">
        <input type="email" class="form-control" name="emails" id="emails" placeholder="esf"
            value="{{ $result -> email }}" required="required" autofocus>
        <label for="floatingName">Email</label>
    </div>
    <!-- Username -->
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" name="usernames" id="usernames" placeholder="esf"
            value="{{ $result -> username }}" required="required" autofocus>
        <label for="floatingName">Nama Pengguna</label>
    </div>
    <!-- Role -->
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" name="roles" id="roles" placeholder="esf" value="{{ $result -> role }}"
            required="required" autofocus>
        <label for="floatingName">Level</label>
    </div>
    <!-- Password
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" name="passwords" id="passwords" placeholder="esf" required="required"
            autofocus>
        <label for="floatingName">Kata Sandi</label>
    </div> -->
</div>
<div class="modal-footer">
    <button type="button" id="modalButtonClose" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    <button type="button" class="btn btn-primary" onClick="updateUserData('{{ $result -> id }}')">Simpan</button>
</div>