<x-default-layout>
    @section('title', 'Prediksi Kinerja Karyawan')

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold mb-0">Form Prediksi Kinerja Karyawan</h3>
            </div>
        </div>

        <div class="card-body pt-0">
            <form id="predictionForm">
                @csrf
                <div class="row g-5">
                    <!-- Jenis Kelamin -->
                    <div class="col-md-6">
                        <div class="fv-row mb-3">
                            <label class="form-label required">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pendidikan Terakhir -->
                    <div class="col-md-6">
                        <div class="fv-row mb-3">
                            <label class="form-label required">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="SMA">SMA</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                            </select>
                        </div>
                    </div>

                    <!-- Lama Bekerja -->
                    <div class="col-md-6">
                        <div class="fv-row mb-3">
                            <label class="form-label required">Lama Bekerja (Tahun)</label>
                            <input type="number" name="lama_bekerja" class="form-control" placeholder="Contoh: 5" required>
                        </div>
                    </div>

                    <!-- Jumlah Kehadiran -->
                    <div class="col-md-6">
                        <div class="fv-row mb-3">
                            <label class="form-label required">Jumlah Kehadiran (Hari)</label>
                            <input type="number" name="jumlah_kehadiran" class="form-control" placeholder="Contoh: 300" required>
                        </div>
                    </div>

                    <!-- Jabatan -->
                    <div class="col-md-6">
                        <div class="fv-row mb-3">
                            <label class="form-label required">Jabatan</label>
                            <select name="jabatan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Staff">Staff</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Prediksi -->
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">
                        {!! getIcon('brain', 'fs-2') !!}
                        <span class="ms-2 fw-semibold">Prediksi</span>
                    </button>
                </div>
            </form>

            <!-- Hasil Prediksi -->
            <div id="predictionResult" class="alert alert-info d-none mt-5">
                <strong>Hasil Prediksi:</strong> <span id="predictionText"></span>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('predictionForm').addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch('{{ route('training.predict') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    const resultBox = document.getElementById('predictionResult');
                    const predictionText = document.getElementById('predictionText');

                    if (result.success) {
                        predictionText.textContent = result.prediction;
                        resultBox.classList.remove('d-none', 'alert-danger');
                        resultBox.classList.add('alert-info');
                    } else {
                        predictionText.textContent = result.message || 'Terjadi kesalahan';
                        resultBox.classList.remove('d-none', 'alert-info');
                        resultBox.classList.add('alert-danger');
                    }

                } catch (error) {
                    const resultBox = document.getElementById('predictionResult');
                    const predictionText = document.getElementById('predictionText');
                    predictionText.textContent = 'Gagal mengirim data ke server';
                    resultBox.classList.remove('d-none', 'alert-info');
                    resultBox.classList.add('alert-danger');
                }
            });
        </script>
    @endpush
</x-default-layout>