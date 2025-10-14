<x-default-layout>
    @section('title', 'Data Karyawan')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('karyawan.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold mb-0">Daftar Karyawan</h3>
            </div>

            <div class="card-toolbar">
                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
                    <i class="ki-duotone ki-plus fs-2"></i> Tambah Karyawan
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <input type="text" id="global_search" class="form-control form-control-sm w-25" placeholder="Cari data...">
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="karyawan_table">
                    <thead>
                        <tr class=" text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">No</th>
                            <th class="min-w-100px">NIK</th>
                            <th class="min-w-150px">Nama</th>
                            <th class="min-w-150px">Jenis Kelamin</th>
                            <th class="min-w-150px">Pendidikan Terakhir</th>
                            <th class="min-w-150px">Lama Bekerja (tahun)</th>
                            <th class="min-w-150px">Jumlah Kehadiran</th>
                            <th class="min-w-150px">Hasil Penilaian Kinerja Sebelumnya (%)</th>
                            <th class="min-w-150px">Jabatan</th>
                            <th class="text-end min-w-100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($karyawan as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $k->nik }}</td>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $k->pendidikan_terakhir }}</td>
                            <td>{{ $k->lama_bekerja }}</td>
                            <td>{{ $k->jumlah_kehadiran }}</td>
                            <td>{{ $k->hasil_penilaian_kinerja_sebelumnya }}</td>
                            <td>{{ $k->jabatan }}</td>
                            <td class="d-flex justify-content-between">
                                <!-- Tombol Edit (buka modal) -->
                                <button type="button" 
                                        class="btn btn-sm btn-light-warning me-1 btn-edit-karyawan" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditKaryawan"
                                        data-id="{{ $k->id }}"
                                        data-nik="{{ $k->nik }}"
                                        data-nama="{{ $k->nama }}"
                                        data-jenis_kelamin="{{ $k->jenis_kelamin }}"
                                        data-pendidikan="{{ $k->pendidikan_terakhir }}"
                                        data-jabatan="{{ $k->jabatan }}"
                                        data-lama_bekerja="{{ $k->lama_bekerja }}"
                                        data-jumlah_kehadiran="{{ $k->jumlah_kehadiran }}"
                                        data-penilaian="{{ $k->hasil_penilaian_kinerja_sebelumnya }}">
                                    {{-- {!! getIcon('pencil', 'fs-2') !!} --}}
                                    <i class="ki-duotone ki-pencil fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('karyawan.destroy', $k) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light-danger btn-hapus-karyawan">
                                        <i class="ki-duotone ki-trash fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Karyawan -->
    @include('pages.karyawan._modal-create')
    
    <!-- Modal Edit Karyawan -->
    @include('pages.karyawan._modal-edit')    

    @push('scripts')
        <script>
            $(document).ready(function () {
                var table = $('#karyawan_table').DataTable();
                $('#global_search').on('keyup', function () {
                    table.search(this.value).draw();
                });

                $('.btn-edit-karyawan').on('click', function () {
                    const id = $(this).data('id');
                    $('#edit_nik').val($(this).data('nik'));
                    $('#edit_nama').val($(this).data('nama'));
                    $('#edit_jenis_kelamin').val($(this).data('jenis_kelamin'));
                    $('#edit_pendidikan').val($(this).data('pendidikan'));
                    $('#edit_jabatan').val($(this).data('jabatan'));
                    $('#edit_lama_bekerja').val($(this).data('lama_bekerja'));
                    $('#edit_jumlah_kehadiran').val($(this).data('jumlah_kehadiran'));
                    $('#edit_penilaian').val($(this).data('penilaian'));

                    $('#formEditKaryawan').attr('action', `/karyawan/${id}`);
                });

                $('.btn-hapus-karyawan').on('click', function(e){
                    e.preventDefault();
                    const form = $(this).closest('form');

                    Swal.fire({
                        title: 'Yakin ingin menghapus karyawan ini?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush

</x-default-layout>