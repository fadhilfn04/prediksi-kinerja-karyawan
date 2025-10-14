<x-default-layout>
    @section('title', 'Hasil Prediksi')

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Hasil Prediksi</h3>
            <a href="{{ route('prediksi.create') }}" class="btn btn-primary">Buat Prediksi</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Nilai Aktual</th>
                        <th>Hasil Prediksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prediksi as $prediksi)
                    <tr>
                        <td>{{ $prediksi->karyawan->nama ?? '-' }}</td>
                        <td>{{ $prediksi->nilai_aktual }}</td>
                        <td>{{ $prediksi->hasil_prediksi }}</td>
                        <td>
                            <a href="{{ route('prediksi.show', $prediksi) }}" class="btn btn-sm btn-info">Detail</a>
                            <form action="{{ route('prediksi.destroy', $prediksi) }}" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $prediksi->links() }}
            </div>
        </div>
    </div>
</x-default-layout>