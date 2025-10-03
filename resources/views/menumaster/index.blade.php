@extends('partials.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Menu Master
                </div>
                <div style="font-size: 12px;">
                    List data Menu Master untuk Website yang aktif dan dimiliki.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" onclick="TambahMenuMaster()">
                        <i class="fa fa-plus"></i> Tambah Menu Master
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive">
                        <table id="menuMasterTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Website</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Link</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuMasters as $item)
                                    <tr class="align-middle">
                                        <td>{{ $item->website->nama ?? '-' }}</td>
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $item->title }}</h6>
                                        </td>
                                        <td>{{ $item->link }}</td>
                                        <td>
                                            @if ($item->active === 'Y')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-id="{{ $item->id }}" data-website_id="{{ $item->website_id }}"
                                                data-title="{{ $item->title }}" data-link="{{ $item->link }}"
                                                data-active="{{ $item->active }}"
                                                onclick="EditMenuMaster(this.dataset.id, this.dataset.website_id, this.dataset.title, this.dataset.link, this.dataset.active)">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="DeleteMenuMaster({{ $item->id }})">
                                                Hapus
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

    @include('menumaster.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#menuMasterTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data Menu Master",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function TambahMenuMaster() {
                $('#newMenuMaster').modal('show');
            }

            function SimpanMenuMaster() {
                let website_id = document.getElementById('website_id').value;
                let title = document.getElementById('title').value;
                let link = document.getElementById('link').value;
                let active = document.getElementById('active').value;

                let formData = new FormData();
                formData.append('website_id', website_id);
                formData.append('title', title);
                formData.append('link', link);
                formData.append('active', active);

                fetch("{{ route('menumaster.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        bootstrap.Modal.getInstance(document.getElementById('newMenuMaster')).hide();
                        Swal.fire({
                            title: data.success ? "Success" : "Error",
                            text: data.message,
                            icon: data.success ? "success" : "error",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => location.reload(), 2000);
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

            function EditMenuMaster(id, website_id, title, link, active) {
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_website_id').value = website_id;
                document.getElementById('edit_title').value = title;
                document.getElementById('edit_link').value = link;
                document.getElementById('edit_active').value = active;

                var modal = new bootstrap.Modal(document.getElementById('editMenuMaster'));
                modal.show();
            }

            function UpdateMenuMaster() {
                let id = document.getElementById('edit_id').value;
                let website_id = document.getElementById('edit_website_id').value;
                let title = document.getElementById('edit_title').value;
                let link = document.getElementById('edit_link').value;
                let active = document.getElementById('edit_active').value;

                let formData = new FormData();
                formData.append('id', id);
                formData.append('website_id', website_id);
                formData.append('title', title);
                formData.append('link', link);
                formData.append('active', active);

                fetch("{{ route('menumaster.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        bootstrap.Modal.getInstance(document.getElementById('editMenuMaster')).hide();
                        Swal.fire({
                            title: data.success ? "Success" : "Error",
                            text: data.message,
                            icon: data.success ? "success" : "error",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => location.reload(), 2000);
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

            function DeleteMenuMaster(id) {
                document.getElementById('menu_master_id_delete').value = id;
                var modal = new bootstrap.Modal(document.getElementById('deleteMenuMaster'));
                modal.show();
            }

            function YakinDeleteMenuMaster() {
                let id = document.getElementById('menu_master_id_delete').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('menumaster.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        bootstrap.Modal.getInstance(document.getElementById('deleteMenuMaster')).hide();
                        Swal.fire({
                            title: data.success ? "Success" : "Error",
                            text: data.message,
                            icon: data.success ? "success" : "error",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Gagal hapus menu master",
                            icon: "error"
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
