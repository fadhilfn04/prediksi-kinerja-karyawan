<div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTambahKaryawanLabel">Tambah Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form action="{{ route('karyawan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-6">
                        <!-- NIK -->
                        <div class="col-md-6 fv-row">
                            <label for="create_nik" class="form-label fw-semibold required">NIK</label>
                            <input type="text" name="nik" id="create_nik" class="form-control form-control-solid" required />
                        </div>

                        <!-- Nama -->
                        <div class="col-md-6 fv-row">
                            <label for="create_nama" class="form-label fw-semibold required">Nama</label>
                            <input type="text" name="nama" id="create_nama" class="form-control form-control-solid" required />
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6 fv-row">
                            <label for="create_jenis_kelamin" class="form-label fw-semibold required">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="create_jenis_kelamin" class="form-select form-select-solid" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Usia -->
                        <div class="col-md-6 fv-row">
                            <label for="create_umur" class="form-label fw-semibold required">Usia</label>
                            <input type="number" name="usia" id="create_umur" class="form-control form-control-solid" required />
                        </div>

                        <!-- Pendidikan -->
                        <div class="col-md-6 fv-row">
                            <label for="create_pendidikan" class="form-label fw-semibold required">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" id="create_pendidikan" class="form-control form-control-solid" required />
                        </div>

                        <!-- Lama Bekerja -->
                        <div class="col-md-6 fv-row">
                            <label for="create_lama_bekerja" class="form-label fw-semibold required">Lama Bekerja</label>
                            <div class="d-flex gap-2">
                                <select name="lama_bekerja_satuan" id="create_lama_bekerja_satuan" class="form-select form-select-solid" required>
                                    <option value="">Pilih Satuan</option>
                                    <option value="TAHUN">Tahun</option>
                                    <option value="BULAN">Bulan</option>
                                </select>
                                <input type="number" name="lama_bekerja_angka" id="create_lama_bekerja_angka" class="form-control form-control-solid" placeholder="Contoh: 2" min="0" required>
                            </div>
                        </div>

                        <!-- Jumlah Kehadiran -->
                        <div class="col-md-6 fv-row">
                            <label for="create_jumlah_kehadiran" class="form-label fw-semibold required">Jumlah Kehadiran</label>
                            <input type="number" name="kehadiran" id="create_jumlah_kehadiran" class="form-control form-control-solid" required />
                        </div>

                        <!-- Penilaian -->
                        <div class="col-md-6 fv-row">
                            <label for="create_penilaian" class="form-label fw-semibold required">Hasil Penilaian Kinerja Sebelumnya</label>
                            <input type="number" step="0.01" name="hasil_penilaian_kinerja_sebelumnya" id="create_penilaian" class="form-control form-control-solid" required />
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6 fv-row">
                            <label for="create_jabatan" class="form-label fw-semibold required">Jabatan</label>
                            <input type="text" name="jabatan" id="create_jabatan" class="form-control form-control-solid" required />
                        </div>

                        <!-- Nilai Produktivitas -->
                        <div class="col-md-6 fv-row">
                            <label for="create_nilai_produktivitas" class="form-label fw-semibold required">Produktivitas Kerja</label>
                            <select name="produktivitas_kerja" id="create_produktivitas_kerja" class="form-select form-select-solid" required>
                                <option value="">Pilih Produktivitas Kerja</option>
                                <option value="Tercapai">Tercapai</option>
                                <option value="Tidak Tercapai">Tidak Tercapai</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>