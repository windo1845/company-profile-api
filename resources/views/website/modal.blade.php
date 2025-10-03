<div class="modal fade" id="newWebsite" tabindex="-1" aria-labelledby="modal-new-website" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Website</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Website</label>
                    <input type="text" id="nama" name="nama" class="form-control" maxlength="100" required>
                </div>

                <div class="mb-3">
                    <label for="domain" class="form-label">Domain</label>
                    <input type="text" id="domain" name="domain" class="form-control" maxlength="150">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Logo / Gambar Website</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event, 'preview-new')">
                    <div class="mt-2">
                        <img id="preview-new" src="" alt="Preview" style="max-height:120px; display:none;" class="rounded shadow-sm">
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanWebsite()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteWebsite" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Website</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="/assets/img/content/info.png" width="50%">
                <hr>
                <div style="font-size: 18px; color: #dd3343;">
                    <b>DELETE WEBSITE</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus website ini?
                </div>
                <input type="hidden" id="website_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeleteWebsite()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editWebsite" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Website</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_website_id">

                <div class="mb-3">
                    <label for="edit_nama" class="form-label">Nama Website</label>
                    <input type="text" id="edit_nama" class="form-control" maxlength="100" required>
                </div>

                <div class="mb-3">
                    <label for="edit_domain" class="form-label">Domain</label>
                    <input type="text" id="edit_domain" class="form-control" maxlength="150">
                </div>

                <div class="mb-3">
                    <label for="edit_image" class="form-label">Logo / Gambar Website</label>
                    <input type="file" id="edit_image" class="form-control" accept="image/*" onchange="previewImage(event, 'preview-edit')">
                    <div class="mt-2">
                        <img id="preview-edit" src="" alt="Preview" style="max-height:120px; display:none;" class="rounded shadow-sm">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateWebsite()">Update</button>
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
