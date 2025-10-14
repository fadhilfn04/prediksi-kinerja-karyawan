<x-default-layout>
    @section('title', 'Edit Kriteria')

    <div class="card shadow-sm">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold mb-0">Form Edit Kriteria</h3>
            </div>
        </div>

        <div class="card-body pt-0">
            <form action="{{ route('kriteria.update', $kriterium) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                <div class="row g-6 mb-8">
                    <!-- Nama Kriteria -->
                    <div class="col-md-6 fv-row">
                        <label for="nama_kriteria" class="form-label fw-semibold required">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" id="nama_kriteria" class="form-control form-control-solid @error('nama_kriteria') is-invalid @enderror" placeholder="Masukkan Nama Kriteria" value="{{ old('nama_kriteria', $kriterium->nama_kriteria) }}" required />
                        @error('nama_kriteria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bobot -->
                    <div class="col-md-6 fv-row">
                        <label for="bobot" class="form-label fw-semibold required">Bobot</label>
                        <input type="number" step="0.01" name="bobot" id="bobot" class="form-control form-control-solid @error('bobot') is-invalid @enderror" placeholder="Masukkan Bobot" value="{{ old('bobot', $kriterium->bobot) }}" required />
                        @error('bobot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tipe -->
                    <div class="col-md-6 fv-row">
                        <label for="tipe" class="form-label fw-semibold required">Tipe</label>
                        <select name="tipe" id="tipe" class="form-select form-control-solid @error('tipe') is-invalid @enderror" required>
                            <option value="">Pilih Tipe</option>
                            <option value="benefit" {{ old('tipe', $kriterium->tipe) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ old('tipe', $kriterium->tipe) == 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('kriteria.index') }}" class="btn btn-light me-3">
                        <i class="ki-duotone ki-arrow-left fs-2"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-check fs-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>