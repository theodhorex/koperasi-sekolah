@extends('layouts.app-master')
@section('content')
<div class="py-5 rounded">
    <h2 class="fw-semibold mb-4">Manajemen Pengguna</h2>
    <div class="row mb-3">
        <div class="col">
            <div class="row mb-3">
                <div class="col">
                    <a href="#" class="btn btn-primary fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Tambah Pengguna</a>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Level</th>
                        <th scope="col">Dibuat pada</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach($user as $data)
                    <tr>
                        <th scope="row" class="nowrap">{{ $i++ }}</th>
                        <td>{{ $data->username }}</td>
                        <td>{{ ucfirst($data->role) }}</td>
                        <td>{{ ($data->created_at)->format('j F Y') }}</td>
                        <td class="nowrap">
                            <a href="#" class="btn btn-sm fw-semibold btn-warning"
                                onClick="showModalEdit('{{ $data -> id }}')" data-bs-toggle="modal"
                                data-bs-target="#exampleModals">Edit</a>
                            <a href="#" onClick="deleteUser('{{ $data -> id }}')"
                                class="btn btn-sm fw-semibold btn-danger">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Modal Add User -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Email -->
                <div class="form-group form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="esf"
                        required="required" autofocus>
                    <label for="floatingName">Email</label>
                </div>
                <!-- Username -->
                <div class="form-group form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="username" placeholder="esf"
                        required="required" autofocus>
                    <label for="floatingName">Nama Pengguna</label>
                </div>
                <!-- Role -->
                <div class="form-group form-floating mb-3">
                    <input type="text" class="form-control" name="role" id="role" placeholder="esf" required="required"
                        autofocus>
                    <label for="floatingName">Level</label>
                </div>
                <!-- Password -->
                <div class="form-group form-floating mb-3">
                    <input type="text" class="form-control" name="password" id="password" placeholder="esf"
                        required="required" autofocus>
                    <label for="floatingName">Kata Sandi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalAddUserCloseButton" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" onClick="addUser()">Simpan</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Edit User -->
<div class="modal fade" id="exampleModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="editModalTarget"></div>
        </div>
    </div>
</div>

<script>
function addUser() {
    $.ajax({
        type: 'GET',
        url: '{{ url("/user-management/add-user") }}',
        data: {
            email: $('#email').val(),
            username: $('#username').val(),
            role: $('#role').val(),
            password: $('#password').val()
        },
        success: function(data) {
            $('#modalAddUserCloseButton').click();
            Swal.fire({
                title: 'Data user berhasil ditambahkan!',
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

function showModalEdit(id) {
    $.get("{{ url('/user-management/edit-user-data') }}/" + id, {}, function(data, status) {
        $("#editModalTarget").html(data);
        $('#exampleModal2').show();
    });
}

function updateUserData(id) {
    $.ajax({
        type: 'GET',
        url: '{{ url("/user-management/update-user-data") }}/' + id,
        data: {
            emails: $('#emails').val(),
            usernames: $('#usernames').val(),
            roles: $('#roles').val(),
            // passwords: $('#passwords').val()
        },
        success: function(data) {
            $('#modalButtonClose').click();
            Swal.fire({
                title: 'Data user berhasil diperbarui!',
                text: "Data berhasil di perbarui!",
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

function deleteUser(id) {
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Akun ini akan dihapus secara permanen dari dalam database!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#cb0c9f',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Data user berhasil dihapus!',
                text: "Data berhasil di dihapus!",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tutup',
                cancelButtonText: 'No'
            }).then(() => {
                url = "/user-management/delete-user/" + id;
                window.location.href = url;
            });
        }
    });
}
</script>
@endsection