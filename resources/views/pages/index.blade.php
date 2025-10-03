@extends('partials.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Menu Pages
                </div>
                <div style="font-size: 12px;">
                    List data Menu Pages / Halaman untuk Website yang aktif dan dimiliki.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" onclick="TambahPage()">
                        <i class="fa fa-plus"></i> Tambah Page
                    </button>
                </div>

                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive">
                        <table id="pagesTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Website</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Link</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Menu Master</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Menu Sub</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pages as $page)
                                    <tr class="align-middle">
                                        <td>{{ $page->website->nama ?? '-' }}</td>
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $page->title }}</h6>
                                        </td>
                                        <td>{{ $page->link }}</td>
                                        <td>{{ $page->menuMaster->title ?? '-' }}</td>
                                        <td>{{ $page->menuSub->title ?? '-' }}</td>
                                        <td>
                                            @if ($page->active === 'Y')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-id="{{ $page->id }}" data-website_id="{{ $page->website_id }}"
                                                data-menu_master_id="{{ $page->menu_master_id }}"
                                                data-menu_sub_id="{{ $page->menu_sub_id }}" data-title="{{ $page->title }}"
                                                data-link="{{ $page->link }}" data-content="{{ $page->content }}"
                                                data-title_en="{{ $page->title_en }}"
                                                data-content_en="{{ $page->content_en }}"
                                                data-active="{{ $page->active }}" onclick="EditPage(this.dataset)">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="DeletePage({{ $page->id }})">
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

    @include('pages.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="{{ asset('vendor/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
        <script src="{{ asset('vendor/summernote/summernote-bs5.min.js') }}"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#pagesTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data Halaman",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            const summernoteConfig = {
                placeholder: 'Tulis isi konten...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontname', 'fontsize', 'strikethrough', 'superscript', 'subscript']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Tahoma',
                    'Times New Roman', 'Verdana'
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150']
            };

            $('#newPage').on('shown.bs.modal', function() {
                if (!$('#page_content').next('.note-editor').length) {
                    $('#page_content').summernote(summernoteConfig);
                }
                if (!$('#page_content_en').next('.note-editor').length) {
                    $('#page_content_en').summernote(summernoteConfig);
                }
            });

            $('#editPage').on('shown.bs.modal', function() {
                if (!$('#edit_page_content').next('.note-editor').length) {
                    $('#edit_page_content').summernote(summernoteConfig);
                }
                if (!$('#edit_page_content_en').next('.note-editor').length) {
                    $('#edit_page_content_en').summernote(summernoteConfig);
                }
            });

            function TambahPage() {
                $('#newPage').modal('show');
            }

            function SimpanPage() {
                let website_id = $('#page_website_id').val();
                let menu_master_id = $('#page_menu_master_id').val();
                let menu_sub_id = $('#page_menu_sub_id').val();
                let title = $('#page_title').val();
                let link = $('#page_link').val();
                let content = $('#page_content').val();
                let title_en = $('#page_title_en').val();
                let content_en = $('#page_content_en').val();
                let active = $('#page_active').val();

                let formData = new FormData();
                formData.append('website_id', website_id);
                formData.append('menu_master_id', menu_master_id);
                formData.append('menu_sub_id', menu_sub_id);
                formData.append('title', title);
                formData.append('link', link);
                formData.append('content', content);
                formData.append('title_en', title_en);
                formData.append('content_en', content_en);
                formData.append('active', active);

                fetch("{{ route('pages.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        bootstrap.Modal.getInstance(document.getElementById('newPage')).hide();
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

            function EditPage(dataset) {
                $('#edit_page_id').val(dataset.id);
                $('#edit_page_website_id').val(dataset.website_id);
                $('#edit_page_menu_master_id').val(dataset.menu_master_id);
                $('#edit_page_menu_sub_id').val(dataset.menu_sub_id);
                $('#edit_page_title').val(dataset.title);
                $('#edit_page_link').val(dataset.link);
                $('#edit_page_content').val(dataset.content);
                $('#edit_page_title_en').val(dataset.title_en);
                $('#edit_page_content_en').val(dataset.content_en);
                $('#edit_page_active').val(dataset.active);

                var modal = new bootstrap.Modal(document.getElementById('editPage'));
                modal.show();
            }

            function UpdatePage() {
                let id = $('#edit_page_id').val();
                let website_id = $('#edit_page_website_id').val();
                let menu_master_id = $('#edit_page_menu_master_id').val();
                let menu_sub_id = $('#edit_page_menu_sub_id').val();
                let title = $('#edit_page_title').val();
                let link = $('#edit_page_link').val();
                let content = $('#edit_page_content').val();
                let title_en = $('#edit_page_title_en').val();
                let content_en = $('#edit_page_content_en').val();
                let active = $('#edit_page_active').val();

                let formData = new FormData();
                formData.append('id', id);
                formData.append('website_id', website_id);
                formData.append('menu_master_id', menu_master_id);
                formData.append('menu_sub_id', menu_sub_id);
                formData.append('title', title);
                formData.append('link', link);
                formData.append('content', content);
                formData.append('title_en', title_en);
                formData.append('content_en', content_en);
                formData.append('active', active);

                fetch("{{ route('pages.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        bootstrap.Modal.getInstance(document.getElementById('editPage')).hide();
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

            function DeletePage(id) {
                $('#page_id_delete').val(id);
                var modal = new bootstrap.Modal(document.getElementById('deletePage'));
                modal.show();
            }

            function YakinDeletePage() {
                let id = $('#page_id_delete').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('pages.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        bootstrap.Modal.getInstance(document.getElementById('deletePage')).hide();
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
                            text: "Gagal hapus page",
                            icon: "error"
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
