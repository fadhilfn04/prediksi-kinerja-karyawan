<x-default-layout>
    @section('title', 'Dashboard')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!-- Statistik Utama -->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!-- Total Karyawan -->
        <div class="col-md-3">
            <div class="card bg-light-primary shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol symbol-50px me-4">
                        {!! getIcon('users', 'fs-2 text-primary') !!}
                    </div>
                    <div>
                        <div class="fs-2 fw-bold">{{ $totalKaryawan }}</div>
                        <div class="text-muted fw-semibold">Total Karyawan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Model Terlatih -->
        <div class="col-md-3">
            <div class="card bg-light-success shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol symbol-50px me-4">
                        {!! getIcon('brain', 'fs-2 text-success') !!}
                    </div>
                    <div>
                        <div class="fs-2 fw-bold">{{ $isModelTrained ? 'Sudah' : 'Belum' }}</div>
                        <div class="text-muted fw-semibold">Model Terlatih</div>
                        @if($isModelTrained)
                            <small class="text-muted">Terakhir: {{ $lastTrainingDate }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Prediksi -->
        <div class="col-md-3">
            <div class="card bg-light-info shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol symbol-50px me-4">
                        {!! getIcon('activity', 'fs-2 text-info') !!}
                    </div>
                    <div>
                        <div class="fs-2 fw-bold">{{ $totalPrediksi }}</div>
                        <div class="text-muted fw-semibold">Total Prediksi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akurasi Model -->
        <div class="col-md-3">
            <div class="card bg-light-warning shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol symbol-50px me-4">
                        {!! getIcon('check-circle', 'fs-2 text-warning') !!}
                    </div>
                    <div>
                        <div class="fs-2 fw-bold">{{ $modelAccuracy ?? '-' }}%</div>
                        <div class="text-muted fw-semibold">Akurasi Model</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Ringkasan Hasil Prediksi & Tabel Prediksi Terbaru -->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!-- Chart -->
        <div class="col-xl-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Ringkasan Hasil Prediksi</h3>
                </div>
                <div class="card-body">
                    <div id="predictionChart"></div>
                </div>
            </div>
        </div>

        <!-- Tabel Prediksi Terbaru -->
        <div class="col-xl-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">Prediksi Terbaru</h3>
                    <a href="{{ route('karyawan.index') }}" class="btn btn-sm btn-light-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="prediksi_table" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan</th>
                                    <th>Jabatan</th>
                                    <th>Prediksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach($latestPredictions as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->nama ?? '-' }}</td>
                                        <td>
                                            @if($p->jenis_kelamin == 'L') Laki-laki
                                            @elseif($p->jenis_kelamin == 'P') Perempuan
                                            @else {{ $p->jenis_kelamin ?? '-' }}
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartData = @json($chartData);
                const labels = chartData.map(item => item.name);
                const series = chartData.map(item => item.y);

                const options = {
                    series: series,
                    chart: { type: 'pie', height: 500 },
                    labels: labels,
                    legend: { position: 'bottom' },
                    responsive: [{
                        breakpoint: 480,
                        options: { chart: { width: '100%' }, legend: { position: 'bottom' } }
                    }],
                    tooltip: {
                        y: { formatter: val => val + " karyawan" }
                    },
                    colors: ['#50CD89', '#FFC700', '#F1416C']
                };

                const chart = new ApexCharts(document.querySelector("#predictionChart"), options);
                chart.render();

                if ($.fn.DataTable.isDataTable('#prediksi_table')) {
                    $('#prediksi_table').DataTable().destroy();
                }

                $('#prediksi_table').DataTable({
                    columnDefs: [
                        { className: 'text-center', targets: '_all' },
                    ],
                });
            });
        </script>
    @endpush
</x-default-layout>
