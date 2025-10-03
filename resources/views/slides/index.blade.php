@extends('partials.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Slides
                </div>
                <div style="font-size: 12px;">
                    List data Gambar untuk slides.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" onclick="TambahSlides()">
                        <i class="fa fa-plus"></i> Tambah Slides
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">

                    <div class="table-responsive">
                        <table id="slidesTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Website</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Gambar</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Update Oleh
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($slides as $item)
                                    <tr class="align-middle">
                                        <td>{{ $item->website->nama ?? '-' }}</td>
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $item->title }}</h6>
                                        </td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Website Image"
                                                    style="max-width:100px; cursor:pointer;"
                                                    onclick="showImageModal('{{ asset('storage/' . $item->image) }}')">
                                            @else
                                                <span class="text-muted">Tidak Ada Gambar</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->updatedByUser->name ?? '-' }}</td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-id="{{ $item->id }}" data-title="{{ $item->title }}"
                                                data-website="{{ $item->website_id }}"
                                                data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}"
                                                onclick="EditSlides(this.dataset.id, this.dataset.title, this.dataset.website, this.dataset.image)">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="DeleteSlides({{ $item->id }})">Hapus
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

    @include('slides.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#slidesTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data Slide",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function TambahSlides() {
                $('#newSlide').modal('show');
            }

            function SimpanSlides() {
                let title = document.getElementById('slide_title').value;
                let website_id = document.getElementById('slide_website').value;
                let image = document.getElementById('slide_image').files[0];

                let formData = new FormData();
                formData.append('title', title);
                formData.append('website_id', website_id);
                if (image) {
                    formData.append('image', image);
                }

                fetch("{{ route('slides.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('newSlide')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Slide berhasil disimpan!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('newSlide')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal simpan slide",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('newSlide')).hide();
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

            function EditSlides(id, title, website_id, image) {
                document.getElementById('edit_slide_id').value = id;
                document.getElementById('edit_slide_title').value = title;
                document.getElementById('edit_slide_website').value = website_id;

                let preview = document.getElementById('preview-edit-slide');
                if (image) {
                    preview.src = image;
                    preview.style.display = "block";
                } else {
                    preview.style.display = "none";
                }

                var modal = new bootstrap.Modal(document.getElementById('editSlide'));
                modal.show();
            }

            function UpdateSlides() {
                let id = document.getElementById('edit_slide_id').value;
                let title = document.getElementById('edit_slide_title').value;
                let website_id = document.getElementById('edit_slide_website').value;
                let image = document.getElementById('edit_slide_image').files[0];

                let formData = new FormData();
                formData.append('id', id);
                formData.append('title', title);
                formData.append('website_id', website_id);
                if (image) {
                    formData.append('image', image);
                }

                fetch("{{ route('slides.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('editSlide')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Slide berhasil diperbarui!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('editSlide')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal update slide",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('editSlide')).hide();
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

            function DeleteSlides(id) {
                document.getElementById('slide_id_delete').value = id;
                var modal = new bootstrap.Modal(document.getElementById('deleteSlide'));
                modal.show();
            }

            function YakinDeleteSlides() {
                let id = document.getElementById('slide_id_delete').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('slides.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('deleteSlide')).hide();
                            Swal.fire({
                                title: "Success",
                                text: data.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('deleteSlide')).hide();
                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    },
                    error: function(xhr) {
                        bootstrap.Modal.getInstance(document.getElementById('deleteSlide')).hide();
                        console.log("Error:", xhr.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Gagal hapus slide",
                            showConfirmButton: false,
                            icon: "error"
                        });
                        setTimeout(() => location.reload(), 2000);
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
