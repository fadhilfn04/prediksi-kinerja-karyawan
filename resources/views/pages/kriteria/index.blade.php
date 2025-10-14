<x-default-layout>
    @section('title', 'Data Kriteria')

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold mb-0">Daftar Kriteria</h3>
            </div>

            <div class="card-toolbar">
                <a href="{{ route('kriteria.create') }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-plus fs-2"></i> Tambah Kriteria
                </a>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kriteria_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-150px">Nama Kriteria</th>
                            <th class="min-w-100px">Bobot</th>
                            <th class="min-w-125px">Tipe</th>
                            <th class="text-end min-w-100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($daftarKriteria as $kriteria)
                        <tr>
                            <td>{{ $kriteria->nama_kriteria }}</td>
                            <td>{{ $kriteria->bobot }}</td>
                            <td>{{ ucfirst($kriteria->tipe) }}</td>
                            <td class="text-end">
                                <!-- Tombol Edit -->
                                <a href="{{ route('kriteria.edit', $kriteria) }}" class="btn btn-sm btn-light-warning me-1" data-bs-toggle="tooltip" title="Edit">
                                    {!! getIcon('pencil', 'fs-2') !!}
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('kriteria.destroy', $kriteria) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light-danger" data-bs-toggle="tooltip" title="Hapus">
                                        {!! getIcon('trash', 'fs-2') !!}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($daftarKriteria->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">Belum ada kriteria</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#kriteria_table').DataTable();
            });
        </script>
    @endpush

</x-default-layout>