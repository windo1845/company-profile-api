<div class="modal fade" id="newPage" tabindex="-1" aria-labelledby="modal-new-page" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Page</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="page_title" class="form-label">Judul (ID)</label>
                    <input type="text" id="page_title" name="title" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="page_content" class="form-label">Isi (ID)</label>
                    <textarea id="page_content" name="content" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label for="page_title_en" class="form-label">Judul (EN)</label>
                    <input type="text" id="page_title_en" name="title_en" class="form-control" maxlength="255">
                </div>

                <div class="mb-3">
                    <label for="page_content_en" class="form-label">Isi (EN)</label>
                    <textarea id="page_content_en" name="content_en" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label for="page_link" class="form-label">Link</label>
                    <input type="text" id="page_link" name="link" class="form-control" maxlength="255" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="page_menu_master_id" class="form-label">Menu Master</label>
                        <select id="page_menu_master_id" name="menu_master_id" class="form-control">
                            @foreach ($menuMasters as $m)
                                <option value="{{ $m->id }}">{{ $m->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="page_menu_sub_id" class="form-label">Menu Sub</label>
                        <select id="page_menu_sub_id" name="menu_sub_id" class="form-control">
                            @foreach ($menuSubs as $s)
                                <option value="{{ $s->id }}">{{ $s->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="page_website_id" class="form-label">Website</label>
                        <select id="page_website_id" name="website_id" class="form-control" required>
                            @foreach ($websites as $w)
                                <option value="{{ $w->id }}"
                                    {{ session('selected_website_id') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="page_active" class="form-label">Status</label>
                    <select id="page_active" name="active" class="form-control">
                        <option value="Y">Aktif</option>
                        <option value="N">Non Aktif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanPage()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletePage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="/assets/img/content/info.png" width="50%">
                <hr>
                <div style="font-size: 18px; color: #dd3343;">
                    <b>DELETE PAGE</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus page ini?
                </div>
                <input type="hidden" id="page_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeletePage()">Yakin</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Edit Page</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_page_id" name="id">

                <div class="mb-3">
                    <label for="edit_page_title" class="form-label">Judul (ID)</label>
                    <input type="text" id="edit_page_title" name="title" class="form-control" maxlength="255" required>
                </div>

                <div class="mb-3">
                    <label for="edit_page_content" class="form-label">Isi (ID)</label>
                    <textarea id="edit_page_content" name="content" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label for="edit_page_title_en" class="form-label">Judul (EN)</label>
                    <input type="text" id="edit_page_title_en" name="title_en" class="form-control" maxlength="255">
                </div>

                <div class="mb-3">
                    <label for="edit_page_content_en" class="form-label">Isi (EN)</label>
                    <textarea id="edit_page_content_en" name="content_en" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label for="edit_page_link" class="form-label">Link</label>
                    <input type="text" id="edit_page_link" name="link" class="form-control" maxlength="255" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="edit_page_menu_master_id" class="form-label">Menu Master</label>
                        <select id="edit_page_menu_master_id" name="menu_master_id" class="form-control">
                            @foreach ($menuMasters as $m)
                                <option value="{{ $m->id }}">{{ $m->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="edit_page_menu_sub_id" class="form-label">Menu Sub</label>
                        <select id="edit_page_menu_sub_id" name="menu_sub_id" class="form-control">
                            @foreach ($menuSubs as $s)
                                <option value="{{ $s->id }}">{{ $s->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="edit_page_website_id" class="form-label">Website</label>
                        <select id="edit_page_website_id" name="website_id" class="form-control" required>
                            @foreach ($websites as $w)
                                <option value="{{ $w->id }}">{{ $w->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_page_active" class="form-label">Status</label>
                    <select id="edit_page_active" name="active" class="form-control">
                        <option value="Y">Aktif</option>
                        <option value="N">Non Aktif</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdatePage()">Update</button>
            </div>
        </div>
    </div>
</div>

