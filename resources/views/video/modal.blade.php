<div class="modal fade" id="newVideo" tabindex="-1" aria-labelledby="modal-new-video" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Video</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Video</label>
                    <input type="text" id="judul" name="judul" class="form-control" maxlength="20" required>
                </div>

                <div class="mb-3">
                    <label for="video_file" class="form-label">Upload Video</label>
                    <input type="file" id="video_file" name="video_file" class="form-control" accept="video/*"
                        required>
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
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="SimpanVideo()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteVideo" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <b>DELETE VIDEO</b>
                </div>
                <div style="font-size: 12px;">
                    Apakah kamu yakin ingin menghapus video ini?
                </div>
                <input type="hidden" id="video_id_delete">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" onclick="YakinDeleteVideo()">Yakin</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editVideo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_video_id">

                <div class="mb-3">
                    <label for="edit_judul" class="form-label">Judul Video</label>
                    <input type="text" id="edit_judul" class="form-control" maxlength="20" required>
                </div>

                <div class="mb-3">
                    <label for="edit_link_video" class="form-label">Video Saat Ini</label>
                    <div id="current_video_name" style="padding-left: 10px;"></div>
                </div>
                <div class="mb-3">
                    <label for="edit_link_video" class="form-label">Upload Video Baru</label>
                    <input type="file" id="edit_link_video" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="edit_website_id" class="form-label">Website</label>
                    <select id="edit_website_id" class="form-select" required>
                        @foreach ($websites as $w)
                            <option value="{{ $w->id }}">{{ $w->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="UpdateVideo()">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 shadow" style="background-color: #000; color: #fff;">
            <div class="modal-body p-0 text-center">
                <div class="position-relative d-inline-block w-100" style="max-width: 800px; margin:auto;">
                    <button type="button" class="position-absolute top-0 end-0 m-3"
                        style="z-index: 1056; background: rgba(255,255,255,0.9); color: #000; border: none;
                        font-size: 1.5rem; font-weight: bold; line-height: 1; border-radius: 50%;
                        width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; 
                        cursor: pointer;" data-bs-dismiss="modal" aria-label="Close">
                        ✕
                    </button>

                    <!-- Aspect Ratio 16:9 -->
                    <div class="ratio ratio-16x9">
                        <video id="modalVideo" class="w-100 rounded shadow" controls>
                            <source src="" type="video/mp4">
                            Browser kamu tidak mendukung video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
