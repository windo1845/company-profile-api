<div class="modal fade" id="newNews" tabindex="-1" aria-labelledby="modal-new-news" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah News</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul (ID)</label>
                    <input type="text" id="judul" name="judul" class="form-control" maxlength="20" required>
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi (ID)</label>
                    <textarea id="isi" name="isi" class="form-control"></textarea>
                </div>


                <div class="mb-3">
                    <label for="judul_en" class="form-label">Judul (EN)</label>
                    <input type="text" id="judul_en" name="judul_en" class="form-control" maxlength="20" required>
                </div>

                <div class="mb-3">
                    <label for="isi_en" class="form-label">Isi (EN)</label>
                    <textarea id="isi_en" name="isi_en" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*"
                        onchange="previewImage(event, 'preview-new')">
                    <div class="mt-2">
                        <img id="preview-new" src="" alt="Preview" style="max-height:150px; display:none;"
                            class="rounded shadow-sm">
                    </div>
                </div>

                @php
                    date_default_timezone_set('Asia/Jakarta');
                    $today = date('Y-m-d');
                @endphp

                <div class="mb-3">
                    <label for="website_id" class="form-label">Website</label>
                    <select id="website_id" name="website_id" class="form-control" required>
                        @foreach ($websites as $website)
                            <option value="{{ $website->id }}"
                                {{ session('selected_website_id') == $website->id ? 'selected' : '' }}>
                                {{ $website->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ $today }}"
                        required>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanNews()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteNews" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="/assets/img/content/info.png" width="50%">
                <hr>
                <div style="font-size: 18px; color: #dd3343;">
                    <b>DELETE NEWS</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus Berita ini?
                </div>
                <input type="hidden" id="news_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeleteNews()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editNews" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_news_id">

                <div class="mb-3">
                    <label for="edit_judul" class="form-label">Judul (ID)</label>
                    <input type="text" id="edit_judul" class="form-control" maxlength="20" required>
                </div>

                <div class="mb-3">
                    <label for="edit_judul_en" class="form-label">Judul (EN)</label>
                    <input type="text" id="edit_judul_en" class="form-control" maxlength="20" required>
                </div>

                <div class="mb-3">
                    <label for="edit_isi" class="form-label">Isi (ID)</label>
                    <textarea id="edit_isi" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="edit_isi_en" class="form-label">Isi (EN)</label>
                    <textarea id="edit_isi_en" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="edit_image" class="form-label">Image</label>
                    <input type="file" id="edit_image" class="form-control" accept="image/*"
                        onchange="previewImage(event, 'preview-edit')">
                    <div class="mt-2">
                        <img id="preview-edit" src="" alt="Preview" style="max-height:150px; display:none;"
                            class="rounded shadow-sm">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_website_id" class="form-label">Website</label>
                    <select id="edit_website_id" class="form-control" required>
                        @foreach ($websites as $website)
                            <option value="{{ $website->id }}">{{ $website->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="edit_tanggal" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateNews()">Update</button>
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
