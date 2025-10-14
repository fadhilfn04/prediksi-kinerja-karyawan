<div class="modal fade" id="modalEditKaryawan" tabindex="-1" aria-labelledby="modalEditKaryawanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalEditKaryawanLabel">Edit Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form id="formEditKaryawan" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-6">
                        <!-- NIK -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_nik" class="form-label fw-semibold required">NIK</label>
                            <input type="text" name="nik" id="edit_nik" class="form-control form-control-solid" required />
                        </div>

                        <!-- Nama -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_nama" class="form-label fw-semibold required">Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control form-control-solid" required />
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_jenis_kelamin" class="form-label fw-semibold required">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select form-select-solid" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Pendidikan -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_pendidikan" class="form-label fw-semibold required">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" id="edit_pendidikan" class="form-control form-control-solid" required />
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_jabatan" class="form-label fw-semibold required">Jabatan</label>
                            <input type="text" name="jabatan" id="edit_jabatan" class="form-control form-control-solid" required />
                        </div>

                        <!-- Lama Bekerja -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_lama_bekerja" class="form-label fw-semibold required">Lama Bekerja (tahun)</label>
                            <input type="number" name="lama_bekerja" id="edit_lama_bekerja" class="form-control form-control-solid" required />
                        </div>

                        <!-- Jumlah Kehadiran -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_jumlah_kehadiran" class="form-label fw-semibold required">Jumlah Kehadiran</label>
                            <input type="number" name="jumlah_kehadiran" id="edit_jumlah_kehadiran" class="form-control form-control-solid" required />
                        </div>

                        <!-- Penilaian -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_penilaian" class="form-label fw-semibold required">Hasil Penilaian Kinerja Sebelumnya (%)</label>
                            <input type="number" step="0.01" name="hasil_penilaian_kinerja_sebelumnya" id="edit_penilaian" class="form-control form-control-solid" required />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-check fs-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>