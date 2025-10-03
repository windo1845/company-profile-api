@extends('partials.app')

<style>
    table td {
        white-space: normal !important;
        word-wrap: break-word;
        max-width: 250px;
    }
</style>

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="font-size: 24px;font-weight: bold;">
                    Data Produk
                </div>
                <div style="font-size: 12px;">
                    List data produk yang akan ditampilkan.
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#newProduct">
                        <i class="fa fa-plus"></i> Tambah Produk
                    </button>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive">
                        <table id="produkTable" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Website</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Nama Produk
                                        (ID)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Product Name
                                        (EN)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Keterangan
                                        (ID)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Description
                                        (EN)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Image</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Ukuran (Kg)
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Ukuran
                                        (Kg/Pcs)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Ukuran (Gram)
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Ukuran
                                        (Gram/Pcs)</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Active</th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Update Oleh
                                    </th>
                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="align-middle">
                                        <td>{{ $product->website->nama ?? '-' }}</td>
                                        <td>{{ $product->nama_produk }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->keterangan_produk }}</td>
                                        <td>{{ $product->product_description }}</td>
                                        <td>
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                                    style="max-width:100px; cursor:pointer;"
                                                    onclick="showImageModal('{{ asset('storage/' . $product->image) }}')">
                                            @else
                                                <span class="text-muted">Tidak Ada Gambar</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->ukuran_produk_kg }}</td>
                                        <td>{{ $product->ukuran_produk_kg_pcs }}</td>
                                        <td>{{ $product->ukuran_produk_g }}</td>
                                        <td>{{ $product->ukuran_produk_g_pcs }}</td>
                                        <td>{{ \Carbon\Carbon::parse($product->tanggal)->translatedFormat('j M Y') }}</td>
                                        <td class='align-middle text-center'>
                                            @if ($product->active === 'Y')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->updatedByUser)
                                                {{ $product->updatedByUser->name }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="EditProduk('{{ $product->id }}','{{ $product->nama_produk }}','{{ $product->product_name }}',
                                                        '{{ $product->ukuran_produk_kg }}','{{ $product->ukuran_produk_kg_pcs }}',
                                                        '{{ $product->ukuran_produk_g }}','{{ $product->ukuran_produk_g_pcs }}',
                                                        '{{ $product->keterangan_produk }}','{{ $product->product_description }}',
                                                        '{{ $product->image }}','{{ $product->active }}',
                                                        '{{ $product->tanggal }}','{{ $product->website_id }}')">
                                                Edit
                                            </button>

                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="DeleteProduk({{ $product->id }})">Hapus</button>
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

    @include('products.modal')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#produkTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ordering: true,
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        emptyTable: "Tidak ada data Produk",
                        paginate: {
                            previous: '<<',
                            next: '>>'
                        }
                    }
                });
            });

            function TambahProduk() {
                $('#newProduct').modal('show');
            }

            function SimpanProduk() {
                let formData = new FormData();
                formData.append("nama_produk", document.getElementById('nama_produk').value);
                formData.append("product_name", document.getElementById('product_name').value);
                formData.append("keterangan_produk", document.getElementById('keterangan_produk').value);
                formData.append("product_description", document.getElementById('product_description').value);
                formData.append("ukuran_produk_kg", document.getElementById('ukuran_produk_kg').value);
                formData.append("ukuran_produk_kg_pcs", document.getElementById('ukuran_produk_kg_pcs').value);
                formData.append("ukuran_produk_g", document.getElementById('ukuran_produk_g').value);
                formData.append("ukuran_produk_g_pcs", document.getElementById('ukuran_produk_g_pcs').value);
                formData.append("website_id", document.getElementById('website_id').value);
                formData.append("tanggal", document.getElementById('tanggal').value);
                formData.append("active", document.getElementById('active').value);

                let image = document.getElementById('image').files[0];
                if (image) {
                    formData.append("image", image);
                }

                fetch("{{ route('produk.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('newProduct')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Produk berhasil disimpan!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('newProduct')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal simpan Produk",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('newProduct')).hide();
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

            function DeleteProduk(id) {
                document.getElementById('product_id_delete').value = id;

                var modalElement = document.getElementById('deleteProduct');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function YakinDeleteProduk() {
                let id = document.getElementById('product_id_delete').value;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('produk.delete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                    },
                    success: function(data) {
                        if (data.success) {
                            var modalElement = document.getElementById('deleteProduct');
                            var modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();
                            bootstrap.Modal.getInstance(document.getElementById('deleteProduct')).hide();
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
                            bootstrap.Modal.getInstance(document.getElementById('deleteProduct')).hide();
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
                        bootstrap.Modal.getInstance(document.getElementById('deleteProduct')).hide();
                        console.log("Error:", xhr.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Gagal hapus produk",
                            showConfirmButton: false,
                            icon: "error"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                });
            }

            function previewImage(event, previewId) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById(previewId);
                    output.src = reader.result;
                    output.style.display = "block";
                };
                reader.readAsDataURL(event.target.files[0]);
            }

            function EditProduk(id, nama_produk, product_name, ukuran_produk_kg, ukuran_produk_kg_pcs, ukuran_produk_g,
                ukuran_produk_g_pcs, keterangan_produk, product_description, image, active, tanggal, website_id) {
                document.getElementById('edit_product_id').value = id;
                document.getElementById('edit_nama_produk').value = nama_produk;
                document.getElementById('edit_product_name').value = product_name;
                document.getElementById('edit_ukuran_produk_kg').value = ukuran_produk_kg;
                document.getElementById('edit_ukuran_produk_kg_pcs').value = ukuran_produk_kg_pcs;
                document.getElementById('edit_ukuran_produk_g').value = ukuran_produk_g;
                document.getElementById('edit_ukuran_produk_g_pcs').value = ukuran_produk_g_pcs;
                document.getElementById('edit_keterangan_produk').value = keterangan_produk;
                document.getElementById('edit_product_description').value = product_description;
                document.getElementById('edit_tanggal').value = tanggal;
                document.getElementById('edit_active').value = active;
                document.getElementById('edit_website_id').value = website_id;

                var modalElement = document.getElementById('editProduct');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }

            function UpdateProduk() {
                let formData = new FormData();
                formData.append("id", document.getElementById('edit_product_id').value);
                formData.append("nama_produk", document.getElementById('edit_nama_produk').value);
                formData.append("product_name", document.getElementById('edit_product_name').value);
                formData.append("keterangan_produk", document.getElementById('edit_keterangan_produk').value);
                formData.append("product_description", document.getElementById('edit_product_description').value);
                formData.append("ukuran_produk_kg", document.getElementById('edit_ukuran_produk_kg').value);
                formData.append("ukuran_produk_kg_pcs", document.getElementById('edit_ukuran_produk_kg_pcs').value);
                formData.append("ukuran_produk_g", document.getElementById('edit_ukuran_produk_g').value);
                formData.append("ukuran_produk_g_pcs", document.getElementById('edit_ukuran_produk_g_pcs').value);
                formData.append("website_id", document.getElementById('edit_website_id').value);
                formData.append("tanggal", document.getElementById('edit_tanggal').value);
                formData.append("active", document.getElementById('edit_active').value);

                let image = document.getElementById('edit_image').files[0];
                if (image) {
                    formData.append("image", image);
                }

                fetch("{{ route('produk.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('editProduct')).hide();
                            Swal.fire({
                                title: "Success",
                                text: "Produk berhasil diperbarui!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            bootstrap.Modal.getInstance(document.getElementById('editProduct')).hide();
                            Swal.fire({
                                title: "Error",
                                text: "Gagal update produk",
                                showConfirmButton: false,
                                icon: "error"
                            });
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        bootstrap.Modal.getInstance(document.getElementById('editProduct')).hide();
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
