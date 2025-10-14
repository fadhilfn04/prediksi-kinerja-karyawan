<x-default-layout>
    @section('title', 'Daftar Prediksi Karyawan')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('prediksi.index') }}
    @endsection

    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title fw-bold">Daftar Prediksi Karyawan</h3>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <input type="text" id="global_search" class="form-control form-control-sm w-25" placeholder="Cari data...">
            </div>

            <div class="table-responsive">
                <table id="prediksi_full_table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Jenis Kelamin</th>
                            <th>Pendidikan</th>
                            <th>Jabatan</th>
                            <th>Prediksi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse($prediksi as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->karyawan->nama ?? '-' }}</td>
                                <td>
                                    @if($p->jenis_kelamin == 'L')
                                        Laki-laki
                                    @elseif($p->jenis_kelamin == 'P')
                                        Perempuan
                                    @else
                                        {{ $p->jenis_kelamin ?? '-' }}
                                    @endif
                                </td>
                                <td>{{ $p->pendidikan_terakhir }}</td>
                                <td>{{ $p->jabatan }}</td>
                                <td>
                                    <span class="badge 
                                        @if($p->prediksi == 'Baik') bg-success
                                        @elseif($p->prediksi == 'Cukup') bg-warning
                                        @else bg-danger @endif">
                                        {{ $p->prediksi }}
                                    </span>
                                </td>
                                <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data prediksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var table = $('#prediksi_full_table').DataTable();

                $('#global_search').on('keyup', function () {
                    table.search(this.value).draw();
                });
            });
        </script>
    @endpush
</x-default-layout>
