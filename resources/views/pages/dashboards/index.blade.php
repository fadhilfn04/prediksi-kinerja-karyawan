<x-default-layout>
    @section('title', 'Dashboard')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!-- Statistik utama -->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-4">
            <div class="card bg-light-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
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
        </div>
        <div class="col-md-4">
            <div class="card bg-light-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            {!! getIcon('brain', 'fs-2 text-success') !!}
                        </div>
                        <div>
                            <div class="fs-2 fw-bold">
                                {{ $isModelTrained ? 'Sudah' : 'Belum' }}
                            </div>
                            <div class="text-muted fw-semibold">Model Terlatih</div>
                            @if($isModelTrained)
                                <small class="text-muted">Terakhir: {{ $lastTrainingDate }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
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
        </div>
    </div>

    <!-- Grafik ringkasan hasil prediksi + tabel -->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!-- Chart -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Ringkasan Hasil Prediksi</h3>
                </div>
                <div class="card-body">
                    <div id="predictionChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Tabel prediksi terbaru -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Prediksi Terbaru</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="prediksi_table" class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan</th>
                                    <th>Jabatan</th>
                                    <th>Prediksi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPredictions as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->jenis_kelamin }}</td>
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
                                        <td>{{ $p->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada data prediksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- ApexCharts -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartData = @json($chartData);

                const labels = chartData.map(item => item.name);
                const series = chartData.map(item => item.y);

                const options = {
                    series: series,
                    chart: {
                        type: 'pie',
                        height: 300
                    },
                    labels: labels,
                    legend: {
                        position: 'bottom'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: { width: '100%' },
                            legend: { position: 'bottom' }
                        }
                    }],
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " karyawan";
                            }
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#predictionChart"), options);
                chart.render();

                $('#prediksi_table').DataTable();
            });
        </script>
    @endpush
</x-default-layout>