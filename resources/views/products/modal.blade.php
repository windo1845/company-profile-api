<div class="modal fade" id="newProduct" tabindex="-1" aria-labelledby="modal-new-product" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Produk</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk (ID)</label>
                        <input type="text" id="nama_produk" name="nama_produk" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="product_name" class="form-label">Product Name (EN)</label>
                        <input type="text" id="product_name" name="product_name" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="keterangan_produk" class="form-label">Keterangan (ID)</label>
                        <textarea id="keterangan_produk" name="keterangan_produk" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="product_description" class="form-label">Description (EN)</label>
                        <textarea id="product_description" name="product_description" class="form-control"></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Produk</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*"
                        onchange="previewImage(event, 'preview-new')">
                    <div class="mt-2">
                        <img id="preview-new" src="" alt="Preview" style="max-height:150px; display:none;"
                            class="rounded shadow-sm">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ukuran_produk_kg" class="form-label">Ukuran (Kg)</label>
                        <input type="text" id="ukuran_produk_kg" name="ukuran_produk_kg" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="ukuran_produk_kg_pcs" class="form-label">Ukuran (Kg/Pcs)</label>
                        <input type="text" id="ukuran_produk_kg_pcs" name="ukuran_produk_kg_pcs"
                            class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ukuran_produk_g" class="form-label">Ukuran (Gram)</label>
                        <input type="text" id="ukuran_produk_g" name="ukuran_produk_g" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="ukuran_produk_g_pcs" class="form-label">Ukuran (Gram/Pcs)</label>
                        <input type="text" id="ukuran_produk_g_pcs" name="ukuran_produk_g_pcs" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="website_id" class="form-label">Website</label>
                        <select id="website_id" name="website_id" class="form-select" required>
                            @foreach ($websites as $w)
                                <option value="{{ $w->id }}"
                                    {{ session('selected_website_id') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="active" class="form-label">Status Produk</label>
                        <select id="active" name="active" class="form-select">
                            <option value="Y" selected>Aktif</option>
                            <option value="N">Non Aktif</option>
                        </select>
                    </div>
                </div>

                @php
                    date_default_timezone_set('Asia/Jakarta');
                    $today = date('Y-m-d');
                @endphp
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control"
                        value="{{ $today }}" required>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanProduk()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <img src="/assets/img/content/info.png" width="50%">
                <hr>
                <div style="font-size: 18px; color: #dd3343;">
                    <b>DELETE PRODUk</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus produk ini?
                </div>
                <input type="hidden" id="product_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeleteProduk()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_product_id">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_nama_produk" class="form-label">Nama Produk (ID)</label>
                        <input type="text" id="edit_nama_produk" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit_product_name" class="form-label">Product Name (EN)</label>
                        <input type="text" id="edit_product_name" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_keterangan_produk" class="form-label">Keterangan (ID)</label>
                        <textarea id="edit_keterangan_produk" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit_product_description" class="form-label">Description (EN)</label>
                        <textarea id="edit_product_description" class="form-control"></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_image" class="form-label">Gambar Produk</label>
                    <input type="file" id="edit_image" class="form-control" accept="image/*"
                        onchange="previewImage(event, 'preview-edit')">
                    <div class="mt-2">
                        <img id="preview-edit" src="" alt="Preview" style="max-height:150px; display:none;"
                            class="rounded shadow-sm">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_ukuran_produk_kg" class="form-label">Ukuran (Kg)</label>
                        <input type="text" id="edit_ukuran_produk_kg" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit_ukuran_produk_kg_pcs" class="form-label">Ukuran (Kg/Pcs)</label>
                        <input type="text" id="edit_ukuran_produk_kg_pcs" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_ukuran_produk_g" class="form-label">Ukuran (Gram)</label>
                        <input type="text" id="edit_ukuran_produk_g" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit_ukuran_produk_g_pcs" class="form-label">Ukuran (Gram/Pcs)</label>
                        <input type="text" id="edit_ukuran_produk_g_pcs" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_website_id" class="form-label">Website</label>
                        <select id="edit_website_id" class="form-select" required>
                            @foreach ($websites as $w)
                                <option value="{{ $w->id }}">{{ $w->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit_active" class="form-label">Status Produk</label>
                        <select id="edit_active" class="form-select">
                            <option value="Y">Aktif</option>
                            <option value="N">Non Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="edit_tanggal" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateProduk()">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center">

                <div class="position-relative d-inline-block">
                    <button type="button" class="position-absolute top-0 end-0 m-2"
                        style="border:none; background:none; font-size:2rem; font-weight:bold; line-height:1; cursor:pointer; color:black;"
                        data-bs-dismiss="modal" aria-label="Close">
                        ✕
                    </button>

                    <img id="modalImage" src="" alt="Full Image" class="img-fluid rounded shadow">
                </div>

            </div>
        </div>
    </div>
</div>
