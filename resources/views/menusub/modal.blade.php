<div class="modal fade" id="newMenuSub" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Menu Sub</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="sub_title" class="form-label">Judul Sub Menu</label>
                    <input type="text" id="sub_title" name="sub_title" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="sub_link" class="form-label">Link</label>
                    <input type="text" id="sub_link" name="sub_link" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="menu_master_id" class="form-label">Menu Master</label>
                    <select id="menu_master_id" name="menu_master_id" class="form-select" required>
                        @foreach ($menuMasters as $m)
                            <option value="{{ $m->id }}">{{ $m->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sub_website_id" class="form-label">Website</label>
                    <select id="sub_website_id" name="sub_website_id" class="form-select">
                        @foreach ($websites as $w)
                            <option value="{{ $w->id }}"
                                {{ session('selected_website_id') == $w->id ? 'selected' : '' }}>{{ $w->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sub_active" class="form-label">Status</label>
                    <select id="sub_active" name="sub_active" class="form-select">
                        <option value="Y">Aktif</option>
                        <option value="N">Non Aktif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanMenuSub()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteMenuSub" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Menu Sub</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="/assets/img/content/info.png" width="50%">
                <hr>
                <div style="font-size: 18px; color: #dd3343;">
                    <b>DELETE MENU SUB</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus menu sub ini?
                </div>
                <input type="hidden" id="menu_sub_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeleteMenuSub()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editMenuSub" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Menu Sub</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_sub_id">

                <div class="mb-3">
                    <label for="edit_sub_title" class="form-label">Judul Sub Menu</label>
                    <input type="text" id="edit_sub_title" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="edit_sub_link" class="form-label">Link</label>
                    <input type="text" id="edit_sub_link" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="edit_menu_master_id" class="form-label">Menu Master</label>
                    <select id="edit_menu_master_id" class="form-select" required>
                        @foreach ($menuMasters as $m)
                            <option value="{{ $m->id }}" {{ session('selected_website_id') == $m->website_id ? 'selected' : '' }}>
                                {{ $m->title }}
                            </option>
                        @endforeach
                    </select>                    
                </div>

                <div class="mb-3">
                    <label for="edit_sub_website_id" class="form-label">Website</label>
                    <select id="edit_sub_website_id" class="form-select">
                        @foreach ($websites as $w)
                            <option value="{{ $w->id }}" {{ session('selected_website_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }}
                            </option>
                        @endforeach
                    </select>                    
                </div>

                <div class="mb-3">
                    <label for="edit_sub_active" class="form-label">Status</label>
                    <select id="edit_sub_active" class="form-select">
                        <option value="Y">Aktif</option>
                        <option value="N">Non Aktif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateMenuSub()">Update</button>
            </div>
        </div>
    </div>
</div>
