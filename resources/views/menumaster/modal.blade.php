<div class="modal fade" id="newMenuMaster" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Menu Master</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Menu</label>
                    <input type="text" id="title" name="title" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">Link</label>
                    <input type="text" id="link" name="link" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
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

                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select id="active" name="active" class="form-select">
                        <option value="Y">Aktif</option>
                        <option value="N">Non Aktif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanMenuMaster()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteMenuMaster" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Menu Master</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="/assets/img/content/info.png" width="50%">
                <hr>
                <div style="font-size: 18px; color: #dd3343;">
                    <b>DELETE MENU MASTER</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus menu master ini?
                </div>
                <input type="hidden" id="menu_master_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeleteMenuMaster()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editMenuMaster" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Menu Master</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_id">

                <div class="mb-3">
                    <label for="edit_title" class="form-label">Judul Menu</label>
                    <input type="text" id="edit_title" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="edit_link" class="form-label">Link</label>
                    <input type="text" id="edit_link" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="edit_website_id" class="form-label">Website</label>
                    <select id="edit_website_id" class="form-select" required>
                        @foreach ($websites as $w)
                            <option value="{{ $w->id }}">{{ $w->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_active" class="form-label">Status</label>
                    <select id="edit_active" class="form-select">
                        <option value="Y">Aktif</option>
                        <option value="N">Non Aktif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateMenuMaster()">Update</button>
            </div>
        </div>
    </div>
</div>
