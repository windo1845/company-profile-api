@extends('partials.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Menu Sub Master
                </div>
                <div style="font-size: 12px;">
                    List data Menu Sub Master untuk Website yang aktif dan dimiliki.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" onclick="TambahMenuSub()">
                        <i class="fa fa-plus"></i>Tambah Menu Sub Master
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive">
                        <table id="menuSubTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Website</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Menu Master
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Link</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuSubs as $item)
                                    <tr class="align-middle">
                                        <td>{{ $item->website->nama ?? '-' }}</td>
                                        <td>{{ $item->menuMaster->title ?? '-' }}</td>
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
                                                data-id="{{ $item->id }}"
                                                data-menu_master_id="{{ $item->menu_master_id }}"
                                                data-website_id="{{ $item->website_id }}" data-title="{{ $item->title }}"
                                                data-link="{{ $item->link }}" data-active="{{ $item->active }}"
                                                onclick="EditMenuSub(this.dataset.id, this.dataset.menu_master_id, this.dataset.website_id, this.dataset.title, this.dataset.link, this.dataset.active)">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="DeleteMenuSub({{ $item->id }})">
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

    @include('menusub.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#menuSubTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data Sub Menu",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function TambahMenuSub() {
                $('#newMenuSub').modal('show');
            }

            function SimpanMenuSub() {
                let menu_master_id = document.getElementById('menu_master_id').value;
                let website_id = document.getElementById('sub_website_id').value;
                let title = document.getElementById('sub_title').value;
                let link = document.getElementById('sub_link').value;
                let active = document.getElementById('sub_active').value;

                let formData = new FormData();
                formData.append('menu_master_id', menu_master_id);
                formData.append('website_id', website_id);
                formData.append('title', title);
                formData.append('link', link);
                formData.append('active', active);

                fetch("{{ route('submenu.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        bootstrap.Modal.getInstance(document.getElementById('newMenuSub')).hide();
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

            function EditMenuSub(id, menu_master_id, website_id, title, link, active) {
                document.getElementById('edit_sub_id').value = id;
                document.getElementById('edit_menu_master_id').value = menu_master_id;
                document.getElementById('edit_sub_website_id').value = website_id;
                document.getElementById('edit_sub_title').value = title;
                document.getElementById('edit_sub_link').value = link;
                document.getElementById('edit_sub_active').value = active;

                var modal = new bootstrap.Modal(document.getElementById('editMenuSub'));
                modal.show();
            }

            function UpdateMenuSub() {
                let id = document.getElementById('edit_sub_id').value;
                let menu_master_id = document.getElementById('edit_menu_master_id').value;
                let website_id = document.getElementById('edit_sub_website_id').value;
                let title = document.getElementById('edit_sub_title').value;
                let link = document.getElementById('edit_sub_link').value;
                let active = document.getElementById('edit_sub_active').value;

                let formData = new FormData();
                formData.append('id', id);
                formData.append('menu_master_id', menu_master_id);
                formData.append('website_id', website_id);
                formData.append('title', title);
                formData.append('link', link);
                formData.append('active', active);

                fetch("{{ route('submenu.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        bootstrap.Modal.getInstance(document.getElementById('editMenuSub')).hide();
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

            function DeleteMenuSub(id) {
                document.getElementById('menu_sub_id_delete').value = id;
                var modal = new bootstrap.Modal(document.getElementById('deleteMenuSub'));
                modal.show();
            }

            function YakinDeleteMenuSub() {
                let id = document.getElementById('menu_sub_id_delete').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('submenu.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        bootstrap.Modal.getInstance(document.getElementById('deleteMenuSub')).hide();
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
                            text: "Gagal hapus menu sub",
                            icon: "error"
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
