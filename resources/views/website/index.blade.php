@extends('partials.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Website
                </div>
                <div style="font-size: 12px;">
                    List data Website yang aktif dan dimiliki.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" onclick="TambahWebsite()">
                        <i class="fa fa-plus"></i> Tambah Website
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">

                    <div class="table-responsive">
                        <table id="websiteTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Domain</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Gambar Icon
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($websites as $item)
                                    <tr class="align-middle">
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $item->nama }}</h6>
                                        </td>
                                        <td>{{ $item->domain ?? '-' }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Website Image"
                                                    style="max-width:100px; cursor:pointer;"
                                                    onclick="showImageModal('{{ asset('storage/' . $item->image) }}')">
                                            @else
                                                <span class="text-muted">Tidak Ada Gambar</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                data-domain="{{ $item->domain }}"
                                                data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}"
                                                onclick="EditWebsite(this.dataset.id, this.dataset.nama, this.dataset.domain, this.dataset.image)">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="DeleteWebsite({{ $item->id }})">Hapus
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

    @include('website.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#websiteTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data Website",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function TambahWebsite() {
                $('#newWebsite').modal('show');
            }

            function SimpanWebsite() {
                let nama = document.getElementById('nama').value;
                let domain = document.getElementById('domain').value;
                let image = document.getElementById('image').files[0];

                let formData = new FormData();
                formData.append('nama', nama);
                formData.append('domain', domain);
                if (image) {
                    formData.append('image', image);
                }

                fetch("{{ route('website.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('newWebsite')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Website berhasil disimpan!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('newWebsite')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal simpan website",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('newWebsite')).hide();
                        console.error("Error:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan server!",
                            showConfirmButton: false,
                            icon: "error"
                        });
                        setTimeout(() => location.reload(), 2000);
                    });
            }

            function EditWebsite(id, nama, domain, image) {
                document.getElementById('edit_website_id').value = id;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_domain').value = domain;

                let preview = document.getElementById('preview-edit');
                if (image) {
                    preview.src = image;
                    preview.style.display = "block";
                } else {
                    preview.style.display = "none";
                }

                var modalElement = document.getElementById('editWebsite');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function UpdateWebsite() {
                let id = document.getElementById('edit_website_id').value;
                let nama = document.getElementById('edit_nama').value;
                let domain = document.getElementById('edit_domain').value;
                let image = document.getElementById('edit_image').files[0];

                let formData = new FormData();
                formData.append('id', id);
                formData.append('nama', nama);
                formData.append('domain', domain);
                if (image) {
                    formData.append('image', image);
                }

                fetch("{{ route('website.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('editWebsite')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Website berhasil diperbarui!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('editWebsite')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal update website",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('editWebsite')).hide();
                        console.error("Error:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan server!",
                            showConfirmButton: false,
                            icon: "error"
                        });
                        setTimeout(() => location.reload(), 2000);
                    });
            }

            function DeleteWebsite(id) {
                document.getElementById('website_id_delete').value = id;
                var modalElement = document.getElementById('deleteWebsite');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function YakinDeleteWebsite() {
                let id = document.getElementById('website_id_delete').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('website.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('deleteWebsite')).hide();
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
                            bootstrap.Modal.getInstance(document.getElementById('deleteWebsite')).hide();
                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        bootstrap.Modal.getInstance(document.getElementById('deleteWebsite')).hide();
                        console.log("Error:", xhr.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Gagal hapus website",
                            showConfirmButton: false,
                            icon: "error"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                });
            }

            function showImageModal(src) {
                document.getElementById('modalImage').src = src;
                var modal = new bootstrap.Modal(document.getElementById('imageModal'), {
                    backdrop: true,
                    keyboard: true
                });
                modal.show();
            }
        </script>
    @endpush
@endsection
