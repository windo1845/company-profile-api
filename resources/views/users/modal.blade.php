<div class="modal fade" id="new" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah User</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Nama lengkap" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email"
                            required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Password" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanUser()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <b>DELETE USER</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus user ini?
                </div>
                <input type="hidden" id="iddel">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-success" onclick="YakinDelete()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_id">

                <div class="mb-3">
                    <label for="edit_name" class="form-label">Nama</label>
                    <input type="text" id="edit_name" class="form-control" placeholder="Nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label for="edit_email" class="form-label">Email</label>
                    <input type="text" id="edit_email" class="form-control" placeholder="Email" required>
                </div>

                <div class="mb-3">
                    <label for="edit_password" class="form-label">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" id="edit_password" class="form-control" placeholder="Password baru">
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateUser()">Update</button>
            </div>
        </div>
    </div>
</div>
