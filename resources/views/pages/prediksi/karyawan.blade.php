<x-default-layout>
    @section('title', 'Hasil Prediksi Saya')

    {{-- @section('breadcrumbs')
        {{ Breadcrumbs::render('prediksi.saya') }}
    @endsection --}}

    <div class="row g-5 g-xl-10">
        <div class="col-md-6 col-xl-4">
            <div class="card bg-light-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            {!! getIcon('user', 'fs-2 text-primary') !!}
                        </div>
                        <div>
                            <div class="fs-2 fw-bold">{{ $prediksi->karyawan->nama ?? '-' }}</div>
                            <div class="text-muted fw-semibold">Nama Karyawan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card bg-light-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            {!! getIcon('activity', 'fs-2 text-success') !!}
                        </div>
                        <div>
                            <div class="fs-2 fw-bold">
                                <span class="badge 
                                    @if($prediksi->prediksi == 'Baik') bg-success
                                    @elseif($prediksi->prediksi == 'Cukup') bg-warning
                                    @else bg-danger @endif">
                                    {{ $prediksi->prediksi }}
                                </span>
                            </div>
                            <div class="text-muted fw-semibold">Prediksi Kinerja</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card bg-light-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            {!! getIcon('calendar', 'fs-2 text-info') !!}
                        </div>
                        <div>
                            <div class="fs-2 fw-bold">{{ $prediksi->created_at->format('d M Y H:i') }}</div>
                            <div class="text-muted fw-semibold">Tanggal Prediksi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail prediksi -->
    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title fw-bold">Detail Prediksi</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Jenis Kelamin:</strong>
                    @if($prediksi->jenis_kelamin == 'L') Laki-laki
                    @elseif($prediksi->jenis_kelamin == 'P') Perempuan
                    @else {{ $prediksi->jenis_kelamin ?? '-' }} @endif
                </li>
                <li class="list-group-item"><strong>Pendidikan Terakhir:</strong> {{ $prediksi->pendidikan_terakhir }}</li>
                <li class="list-group-item"><strong>Lama Bekerja:</strong> {{ $prediksi->lama_bekerja }} tahun</li>
                <li class="list-group-item"><strong>Jumlah Kehadiran:</strong> {{ $prediksi->jumlah_kehadiran }} hari</li>
                <li class="list-group-item"><strong>Jabatan:</strong> {{ $prediksi->jabatan }}</li>
            </ul>
        </div>
    </div>
</x-default-layout>
