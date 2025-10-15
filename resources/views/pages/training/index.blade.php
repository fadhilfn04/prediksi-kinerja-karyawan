<x-default-layout>
    @section('title', 'Training Model - Decision Tree')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('training.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold mb-0">Proses Klasifikasi</h3>
            </div>

            <div class="card-toolbar">
                <button id="btnAmbil" class="btn btn-light-primary me-2">
                    <i class="ki-duotone ki-some-files">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    </i> Ambil Data
                </button>
                <button id="btnReturn" class="btn btn-light-info me-2">
                    <i class="ki-duotone ki-eye">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i> Return Data
                </button>
                <button id="btnProses" class="btn btn-light-warning me-2">
                    <i class="ki-duotone ki-tree">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i> Proses Decision Tree
                </button>
                <button id="btnSimpan" class="btn btn-light-success">
                    <i class="ki-duotone ki-file-added">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i> Simpan Model
                </button>
            </div>
        </div>

        <div class="card-body pt-0">

            {{-- Status Step --}}
            <div class="mb-6">
                <div id="stepStatus" class="alert alert-secondary d-none mb-0"></div>
            </div>

            {{-- Preview Data Table --}}
            <div class="table-responsive mb-10">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="training_table">
                    <thead class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"></thead>
                    <tbody class="fw-semibold text-gray-600"></tbody>
                </table>
            </div>

            {{-- Preview Decision Tree --}}
            <div>
                <h5 class="fw-bold mb-3">Struktur Decision Tree</h5>
                <pre id="treePreview" class="bg-light p-4 rounded small" style="max-height: 400px; overflow: auto;"></pre>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            const baseUrl = "{{ url('training') }}";
            const stepStatus = document.getElementById('stepStatus');
            const tableHead = document.querySelector('#training_table thead');
            const tableBody = document.querySelector('#training_table tbody');

            function showStatus(message, type = 'secondary') {
                stepStatus.className = `alert alert-${type}`;
                stepStatus.textContent = message;
                stepStatus.classList.remove('d-none');
            }

            let trainingDataTable;

            function renderTable(data) {
                tableHead.innerHTML = '';
                tableBody.innerHTML = '';

                if (!data || data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="100%" class="text-center">Tidak ada data</td></tr>`;
                } else {
                    const headers = Object.keys(data[0]);
                    tableHead.innerHTML = `<tr>${headers.map(h => `<th class="text-center">${h}</th>`).join('')}</tr>`;

                    data.forEach(row => {
                        tableBody.innerHTML += `<tr>${headers.map(h => `<td class="text-center">${row[h]}</td>`).join('')}</tr>`;
                    });
                }

                // Destroy previous DataTable instance (jika ada)
                if ($.fn.DataTable.isDataTable('#training_table')) {
                    $('#training_table').DataTable().destroy();
                }

                // Re-init DataTable
                trainingDataTable = $('#training_table').DataTable();
            }

            document.getElementById('btnAmbil').addEventListener('click', () => {
                fetch(`${baseUrl}/ambil-data`)
                    .then(r => r.json())
                    .then(res => showStatus(res.message, res.success ? 'success' : 'danger'));
            });

            document.getElementById('btnReturn').addEventListener('click', () => {
                fetch(`${baseUrl}/return-data`)
                    .then(r => r.json())
                    .then(res => {
                        renderTable(res.data);
                        showStatus(res.message, res.success ? 'info' : 'danger');
                    });
            });

            document.getElementById('btnProses').addEventListener('click', () => {
                fetch(`${baseUrl}/proses`)
                    .then(r => r.json())
                    .then(res => {
                        document.getElementById('treePreview').textContent = JSON.stringify(res.tree, null, 2);
                        showStatus(res.message, res.success ? 'warning' : 'danger');
                    });
            });

            document.getElementById('btnSimpan').addEventListener('click', () => {
                fetch(`${baseUrl}/simpan`)
                    .then(r => r.json())
                    .then(res => showStatus(res.message, res.success ? 'success' : 'danger'));
            });
        </script>
    @endpush

</x-default-layout>