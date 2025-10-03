@extends('partials.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data User
                </div>
                <div style="font-size: 12px;">
                    List data user untuk login dan membuat data master.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#new">
                        <i class="fa fa-plus"></i> Tambah User
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive">
                        <table id="userTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Nama
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="align-middle">
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-center text-sm">{{ $user->name }}</h6>
                                        </td>
                                        <td>
                                            <p class="text-sm text-center font-weight-bold mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="Edit({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="Delete({{ $user->id }})">Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('users.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#userTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    language: {
                        emptyTable: "Tidak ada data User",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function Tambah() {
                $('#new').modal('show');
            }

            function SimpanUser() {
                let name = document.getElementById('name').value;
                let email = document.getElementById('email').value;
                let password = document.getElementById('password').value;

                fetch("{{ route('user.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            name: name,
                            email: email,
                            password: password
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Tutup modal
                            var modalElement = document.getElementById('new');
                            var modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();

                            // Swal success
                            Swal.fire({
                                title: "Success",
                                text: "User berhasil disimpan!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Gagal simpan User",
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan server!",
                            icon: "error"
                        });
                    });
            }

            function Delete(id) {
                document.getElementById('iddel').value = id;

                var modalElement = document.getElementById('delete');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function YakinDelete() {
                let id = document.getElementById('iddel').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        if (data.success) {
                            var modalElement = document.getElementById('delete');
                            var modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            Swal.fire({
                                title: "Success",
                                text: data.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000,
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr.responseText);
                        alert("Gagal hapus User");
                    }

                });
            }

            function Edit(id, name, email) {
                // Set data ke input modal
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_password').value = "";

                // Tampilkan modal
                var modalElement = document.getElementById('edit');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function UpdateUser() {
                let id = document.getElementById('edit_id').value;
                let name = document.getElementById('edit_name').value;
                let email = document.getElementById('edit_email').value;
                let password = document.getElementById('edit_password').value;

                fetch("{{ route('user.update') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            id: id,
                            name: name,
                            email: email,
                            password: password
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var modalElement = document.getElementById('edit');
                            var modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();

                            Swal.fire({
                                title: "Success",
                                text: "User berhasil diperbarui!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Gagal update User",
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan server!",
                            icon: "error"
                        });
                    });
            }
        </script>
    @endpush
@endsection
