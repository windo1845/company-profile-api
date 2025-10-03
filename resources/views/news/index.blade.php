@extends('partials.app')
<style>
    .note-editor .note-editable {
        min-height: 100px;
        max-height: 400px;
        overflow-y: auto;
    }
</style>

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Berita
                </div>
                <div style="font-size: 12px;">
                    List data berita yang akan ditampilkan.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" onclick="TambahNews()">
                        <i class="fa fa-plus"></i> Tambah Berita
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive">
                        <table id="newsTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Website</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Judul (ID)
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Judul (EN)
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Isi (ID)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Isi (EN)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Image</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Update Oleh
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $item)
                                    <tr class="align-middle">
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $item->website->nama ?? '-' }}</h6>
                                        </td>
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $item->judul }}</h6>
                                        </td>
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $item->judul_en }}</h6>
                                        </td>
                                        <td class="isi-col" style="word-wrap: break-word; white-space: normal;">
                                            <p class="text-sm mb-0">{!! $item->isi ? str_replace('&nbsp;', ' ', $item->isi) : '' !!}</p>
                                        </td>
                                        <td class="isi-col" style="word-wrap: break-word; white-space: normal;">
                                            <p class="text-sm mb-0">{!! $item->isi_en ? str_replace('&nbsp;', ' ', $item->isi_en) : '' !!}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('j M Y') }}</p>
                                        </td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Image"
                                                    style="max-width:100px; cursor:pointer;"
                                                    onclick="showImageModal('{{ asset('storage/' . $item->image) }}')">
                                            @else
                                                <span class="text-muted">Tidak Ada Gambar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->updatedByUser)
                                                {{ $item->updatedByUser->name }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="EditNews({{ $item->id }},'{{ $item->judul }}',
                                                        '{{ $item->judul_en }}','{{ $item->isi }}','{{ $item->isi_en }}',
                                                        '{{ $item->tanggal }}','{{ $item->image }}','{{ $item->website_id }}')">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="DeleteNews({{ $item->id }})">Hapus
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

    @include('news.modal')

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
                $('#newsTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data Berita",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function TambahNews() {
                $('#newNews').modal('show');
            }

            const summernoteConfig = {
                placeholder: 'Tulis isi berita...',
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

            $('#newNews').on('shown.bs.modal', function() {
                if (!$('#isi').next('.note-editor').length) {
                    $('#isi').summernote(summernoteConfig);
                }
                if (!$('#isi_en').next('.note-editor').length) {
                    $('#isi_en').summernote(summernoteConfig);
                }
            });

            $('#editNews').on('shown.bs.modal', function() {
                if (!$('#edit_isi').next('.note-editor').length) {
                    $('#edit_isi').summernote(summernoteConfig);
                }
                if (!$('#edit_isi_en').next('.note-editor').length) {
                    $('#edit_isi_en').summernote(summernoteConfig);
                }
            });

            function SimpanNews() {
                let judul = document.getElementById('judul').value;
                let judul_en = document.getElementById('judul_en').value;
                let isi = $('#isi').summernote('code');
                let isi_en = $('#isi_en').summernote('code');
                let tanggal = document.getElementById('tanggal').value;
                let website_id = document.getElementById('website_id').value;
                let imageInput = document.getElementById('image');

                let formData = new FormData();
                formData.append('judul', judul);
                formData.append('judul_en', judul_en);
                formData.append('isi', isi);
                formData.append('isi_en', isi_en);
                formData.append('tanggal', tanggal);
                formData.append('website_id', website_id);
                if (imageInput.files[0]) {
                    formData.append('image', imageInput.files[0]);
                }

                fetch("{{ route('news.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('newNews')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "News berhasil disimpan!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('newNews')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal simpan news",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('newNews')).hide();
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

            function DeleteNews(id) {
                document.getElementById('news_id_delete').value = id;

                var modalElement = document.getElementById('deleteNews');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function YakinDeleteNews() {
                let id = document.getElementById('news_id_delete').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('news.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('deleteNews')).hide();
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
                            bootstrap.Modal.getInstance(document.getElementById('deleteNews')).hide();
                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                icon: "error"
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        bootstrap.Modal.getInstance(document.getElementById('deleteNews')).hide();
                        console.log("Error:", xhr.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Gagal hapus news",
                            icon: "error"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                });
            }

            function EditNews(id, judul, judul_en, isi, isi_en, tanggal, image, website_id) {
                document.getElementById('edit_news_id').value = id;
                document.getElementById('edit_judul').value = judul;
                document.getElementById('edit_judul_en').value = judul_en;
                document.getElementById('edit_isi').value = isi;
                document.getElementById('edit_isi_en').value = isi_en;
                document.getElementById('edit_tanggal').value = tanggal;
                document.getElementById('edit_website_id').value = website_id;

                const preview = document.getElementById('preview-edit');
                if (image) {
                    preview.src = "{{ asset('storage') }}/" + image;
                    preview.style.display = "block";
                } else {
                    preview.src = "";
                    preview.style.display = "none";
                }

                var modalElement = document.getElementById('editNews');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function UpdateNews() {
                let id = document.getElementById('edit_news_id').value;
                let judul = document.getElementById('edit_judul').value;
                let judul_en = document.getElementById('edit_judul_en').value;
                let isi = $('#edit_isi').summernote('code');
                let isi_en = $('#edit_isi_en').summernote('code');
                let tanggal = document.getElementById('edit_tanggal').value;
                let website_id = document.getElementById('edit_website_id').value;
                let imageInput = document.getElementById('edit_image');

                let formData = new FormData();
                formData.append('id', id);
                formData.append('judul', judul);
                formData.append('judul_en', judul_en);
                formData.append('isi', isi);
                formData.append('isi_en', isi_en);
                formData.append('tanggal', tanggal);
                formData.append('website_id', website_id);
                if (imageInput.files[0]) {
                    formData.append('image', imageInput.files[0]);
                }

                fetch("{{ route('news.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('editNews')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "News berhasil diperbarui!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('editNews')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal update news",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('editNews')).hide();
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

            function previewImage(event, previewId) {
                const input = event.target;
                const preview = document.getElementById(previewId);

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = "";
                    preview.style.display = "none";
                }
            }

            function showImageModal(src) {
                document.getElementById('modalImage').src = src;

                var modalElement = document.getElementById('imageModal');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        </script>
    @endpush
@endsection
