<div class="modal fade" id="newSlide" tabindex="-1" aria-labelledby="modal-new-slide" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Slide</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="slide_title" class="form-label">Judul Slide</label>
                    <input type="text" id="slide_title" name="title" class="form-control" maxlength="100" required>
                </div>

                <div class="mb-3">
                    <label for="slide_website" class="form-label">Website</label>
                    <select id="slide_website" name="website_id" class="form-control">
                        @foreach ($websites as $website)
                            <option value="{{ $website->id }}"
                                {{ session('selected_website_id') == $website->id ? 'selected' : '' }}>
                                {{ $website->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="slide_image" class="form-label">Gambar Slide</label>
                    <input type="file" id="slide_image" name="image" class="form-control" accept="image/*"
                        onchange="previewImage(event, 'preview-new-slide')">
                    <div class="mt-2">
                        <img id="preview-new-slide" src="" alt="Preview"
                            style="max-height:120px; display:none;" class="rounded shadow-sm">
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanSlides()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteSlide" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Slide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="/assets/img/content/info.png" width="50%">
                <hr>
                <div style="font-size: 18px; color: #dd3343;">
                    <b>DELETE SLIDE</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus slide ini?
                </div>
                <input type="hidden" id="slide_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeleteSlides()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editSlide" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Slide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_slide_id">

                <div class="mb-3">
                    <label for="edit_slide_title" class="form-label">Judul Slide</label>
                    <input type="text" id="edit_slide_title" class="form-control" maxlength="100" required>
                </div>

                <div class="mb-3">
                    <label for="edit_slide_website" class="form-label">Website</label>
                    <select id="edit_slide_website" class="form-control">
                        @foreach ($websites as $website)
                            <option value="{{ $website->id }}">{{ $website->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_slide_image" class="form-label">Gambar Slide</label>
                    <input type="file" id="edit_slide_image" class="form-control" accept="image/*"
                        onchange="previewImage(event, 'preview-edit-slide')">
                    <div class="mt-2">
                        <img id="preview-edit-slide" src="" alt="Preview"
                            style="max-height:120px; display:none;" class="rounded shadow-sm">
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateSlides()">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
