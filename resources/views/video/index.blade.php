@extends('partials.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Video
                </div>
                <div style="font-size: 12px;">
                    List data Video yang akan ditampilkan.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" onclick="TambahVideo()">
                        <i class="fa fa-plus"></i> Tambah Video
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive">
                        <table id="videoTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Website</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Link Video
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Update Oleh
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $item)
                                    <tr class="align-middle">
                                        <td>{{ $item->website->nama ?? '-' }}</td>
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">{{ $item->judul }}</h6>
                                        </td>
                                        <td>
                                            @if ($item->link_video)
                                                <a href="javascript:void(0);"
                                                    onclick="showVideoModal('{{ asset('storage/' . $item->link_video) }}')">
                                                    Klik disini untuk Lihat Video
                                                </a>
                                            @else
                                                Tidak ada video
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->updatedByUser->name ?? '-' }}
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-id="{{ $item->id }}" data-judul="{{ $item->judul }}"
                                                data-link="{{ $item->link_video }}" data-website="{{ $item->website_id }}"
                                                onclick="EditVideo(this)">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="DeleteVideo({{ $item->id }})">Hapus
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

    @include('video.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#videoTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data video",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function TambahVideo() {
                $('#newVideo').modal('show');
            }

            function SimpanVideo() {
                let judul = document.getElementById('judul').value;
                let website_id = document.getElementById('website_id').value;
                let video_file = document.getElementById('video_file').files[0];

                let formData = new FormData();
                formData.append('judul', judul);
                formData.append('website_id', website_id);
                formData.append('video_file', video_file);

                fetch("{{ route('video.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('newVideo')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Video berhasil diupload!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('newVideo')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal upload video",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('newVideo')).hide();
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

            function EditVideo(el) {
                let id = el.getAttribute('data-id');
                let judul = el.getAttribute('data-judul');
                let link_video = el.getAttribute('data-link');
                let website_id = el.getAttribute('data-website');

                document.getElementById('edit_video_id').value = id;
                document.getElementById('edit_judul').value = judul;

                if (link_video) {
                    let video_url = "{{ asset('storage/') }}/" + link_video;
                    document.getElementById('current_video_name').innerHTML =
                        `<a href="#" onclick="showVideoModal('${video_url}'); return false;">Klik disini untuk Lihat Video</a>`;
                } else {
                    document.getElementById('current_video_name').innerHTML = 'Tidak ada video';
                }


                document.getElementById('edit_website_id').value = website_id ?? '';

                var modalElement = document.getElementById('editVideo');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function UpdateVideo() {
                let id = document.getElementById('edit_video_id').value;
                let judul = document.getElementById('edit_judul').value;
                let website_id = document.getElementById('edit_website_id').value;
                let link_video = document.getElementById('edit_link_video').files[0];

                let formData = new FormData();
                formData.append('id', id);
                formData.append('judul', judul);
                formData.append('website_id', website_id);
                if (link_video) {
                    formData.append('link_video', link_video);
                }

                fetch("{{ route('video.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('editVideo')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Video berhasil diperbarui!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('editVideo')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal update video",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('editVideo')).hide();
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

            function DeleteVideo(id) {
                document.getElementById('video_id_delete').value = id;
                var modalElement = document.getElementById('deleteVideo');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function YakinDeleteVideo() {
                let id = document.getElementById('video_id_delete').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('video.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('deleteVideo')).hide();
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
                            bootstrap.Modal.getInstance(document.getElementById('deleteVideo')).hide();
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
                        bootstrap.Modal.getInstance(document.getElementById('deleteVideo')).hide();
                        console.log("Error:", xhr.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Gagal hapus video",
                            showConfirmButton: false,
                            icon: "error"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                });
            }

            function showVideoModal(videoUrl) {
                let videoElement = document.getElementById('modalVideo');
                videoElement.querySelector('source').setAttribute('src', videoUrl);
                videoElement.load();
                let modal = new bootstrap.Modal(document.getElementById('videoModal'));
                modal.show();
            }
        </script>
    @endpush
@endsection
