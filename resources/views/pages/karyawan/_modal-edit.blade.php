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
                            <select class="form-select form-select-solid" name="jenis_kelamin" id="edit_jenis_kelamin" data-kt-select2="true" data-placeholder="Pilih Jenis Kelamin" data-allow-clear="true" data-hide-search="true" required>
                                <option></option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Usia -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_usia" class="form-label fw-semibold required">Usia</label>
                            <input type="number" name="usia" id="edit_usia" class="form-control form-control-solid" required />
                        </div>

                        <!-- Pendidikan -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_pendidikan" class="form-label fw-semibold required">Pendidikan Terakhir</label>
                            <select class="form-select form-select-solid" name="pendidikan_terakhir" id="edit_pendidikan" data-kt-select2="true" data-placeholder="Pilih Pendidikan Terakhir" data-allow-clear="true" data-hide-search="true" required>
                                <option></option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                            </select>
                        </div>

                        <!-- Lama Bekerja -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_lama_bekerja" class="form-label fw-semibold required">Lama Bekerja</label>
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-solid" name="lama_bekerja_satuan" id="edit_lama_bekerja_satuan" data-kt-select2="true" data-placeholder="Pilih Satuan" data-allow-clear="true" data-hide-search="true" required>
                                    <option></option>
                                    <option value="TAHUN">Tahun</option>
                                    <option value="BULAN">Bulan</option>
                                </select>
                                <input type="number" name="lama_bekerja_angka" id="edit_lama_bekerja_angka" class="form-control form-control-solid" placeholder="Contoh: 2" min="0" required>
                            </div>
                        </div>

                        <!-- Jumlah Kehadiran -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_jumlah_kehadiran" class="form-label fw-semibold required">Jumlah Kehadiran</label>
                            <input type="number" name="kehadiran" id="edit_jumlah_kehadiran" class="form-control form-control-solid" required />
                        </div>

                        <!-- Penilaian -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_penilaian" class="form-label fw-semibold required">Hasil Penilaian Kinerja Sebelumnya</label>
                            <input type="number" step="0.01" name="hasil_penilaian_kinerja_sebelumnya" id="edit_penilaian" class="form-control form-control-solid" required />
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_jabatan" class="form-label fw-semibold required">Jabatan</label>
                            <select class="form-select form-select-solid" name="jabatan" id="edit_jabatan" data-kt-select2="true" data-placeholder="Pilih Jabatan" data-allow-clear="true" data-hide-search="true" required>
                                <option></option>
                                <option value="COS">COS</option>
                                <option value="ACOS">ACOS</option>
                                <option value="CREW">CREW</option>
                            </select>
                        </div>

                        <!-- Nilai Produktivitas -->
                        <div class="col-md-6 fv-row">
                            <label for="edit_produktivitas_kerja" class="form-label fw-semibold required">Produktivitas Kerja</label>
                            <select class="form-select form-select-solid" name="produktivitas_kerja" id="edit_produktivitas_kerja" data-kt-select2="true" data-placeholder="Pilih Produktivitas Kerja" data-allow-clear="true" data-hide-search="true" required>
                                <option></option>
                                <option value="TERCAPAI">TERCAPAI</option>
                                <option value="TIDAK TERCAPAI">TIDAK TERCAPAI</option>
                            </select>
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