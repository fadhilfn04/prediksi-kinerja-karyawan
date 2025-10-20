<x-default-layout>
    @section('title', 'Data Karyawan')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('karyawan.index') }}
    @endsection

    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari data..." id="global_search"/>
                </div>
                <!--end::Search-->

            <div class="card-toolbar">
                <button type="button" class="btn btn-light-warning me-2" data-bs-toggle="modal" data-bs-target="#modalImportKaryawan">
                    <i class="ki-duotone ki-file-up">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i> Import Excel
                </button>

                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
                    <i class="ki-duotone ki-plus fs-2"></i> Tambah Karyawan
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="karyawan_table">
                    <thead>
                        <tr class=" text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">No</th>
                            <th class="min-w-100px">NIK</th>
                            <th class="min-w-150px">Nama</th>
                            <th class="min-w-150px">Usia</th>
                            <th class="min-w-150px">Jenis Kelamin</th>
                            <th class="min-w-150px">Pendidikan Terakhir</th>
                            <th class="min-w-150px">Lama Bekerja</th>
                            <th class="min-w-150px">Jumlah Kehadiran</th>
                            <th class="min-w-150px">Hasil Penilaian Kinerja Sebelumnya</th>
                            <th class="min-w-150px">Produktivitas Kerja</th>
                            <th class="min-w-150px">Jabatan</th>
                            <th class="min-w-150px">Prediksi</th>
                            <th class="min-w-150px">Tanggal Prediksi</th>
                            <th class="text-end min-w-100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($karyawan as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $k->nik }}</td>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->usia }}</td>
                            <td>{{ $k->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $k->pendidikan_terakhir }}</td>
                            <td>{{ $k->lama_bekerja }}</td>
                            <td>{{ $k->kehadiran }}</td>
                            <td>{{ $k->hasil_penilaian_kinerja_sebelumnya }}</td>
                            <td>{{ $k->produktivitas_kerja }}</td>
                            <td>{{ $k->jabatan }}</td>
                            <td>
                                @if(isset($k->prediksi))
                                    <span class="badge 
                                        @if($k->prediksi == 'Baik') bg-success
                                        @elseif($k->prediksi == 'Cukup') bg-warning
                                        @else bg-danger @endif">
                                        {{ $k->prediksi }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Belum diprediksi</span>
                                @endif
                            </td>

                            <td>
                                @if(isset($k->tanggal_prediksi))
                                    {{ \Carbon\Carbon::parse($k->tanggal_prediksi)->format('d M Y H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-between">
                                <!-- Tombol Edit (buka modal) -->
                                <button type="button" 
                                    class="btn btn-sm btn-light-warning me-1 btn-edit-karyawan" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditKaryawan"
                                    data-id="{{ $k->id }}"
                                    data-nik="{{ $k->nik }}"
                                    data-nama="{{ $k->nama }}"
                                    data-usia="{{ $k->usia }}"
                                    data-jenis_kelamin="{{ $k->jenis_kelamin }}"
                                    data-pendidikan="{{ $k->pendidikan_terakhir }}"
                                    data-lama_bekerja="{{ $k->lama_bekerja }}"
                                    data-kehadiran="{{ $k->kehadiran }}"
                                    data-penilaian="{{ $k->hasil_penilaian_kinerja_sebelumnya }}"
                                    data-jabatan="{{ $k->jabatan }}"
                                    data-produktivitas_kerja="{{ $k->produktivitas_kerja }}">
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

    <!-- Modal Import Karyawan -->
    <div class="modal fade" id="modalImportKaryawan" tabindex="-1" aria-labelledby="modalImportKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalImportKaryawanLabel">Import Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-muted fs-7">
                            <i class="ki-duotone ki-information">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i> Unduh template untuk memastikan format sesuai.
                        </div>
                        <a href="{{ asset('template_karyawan.xlsx') }}" class="btn btn-sm btn-light-primary" download>
                            Download Template
                        </a>
                    </div>

                    <form action="{{ route('karyawan.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file_import" class="form-label fw-semibold">Pilih File Excel (.xls / .xlsx)</label>
                            <input type="file" name="file" id="file_import" class="form-control" accept=".xls,.xlsx" required>
                        </div>
                        <div class="text-muted fs-7">
                            <i class="ki-duotone ki-alert fs-3"></i> Pastikan semua kolom terisi dengan benar sebelum diimport.
                        </div>

                        <div class="modal-footer px-0 mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ki-duotone ki-file-up">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i> Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                })
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Coba Lagi'
                })
            @endif

            $(document).ready(function () {
                var table = $('#karyawan_table').DataTable({
                    scrollX: true,
                    scrollCollapse: true,
                    paging: true,
                    columnDefs: [
                        { className: 'text-center', targets: '_all' },
                        { orderable: false, targets: -1 }
                    ],
                    fixedColumns: {
                        leftColumns: 3
                    }
                });
                $('#global_search').on('keyup', function () {
                    table.search(this.value).draw();
                });

                $(document).on('click', '.btn-edit-karyawan', function () {
                    const id = $(this).data('id');

                    $('#edit_nik').val($(this).data('nik'));
                    $('#edit_nama').val($(this).data('nama'));
                    $('#edit_usia').val($(this).data('usia'));
                    $('#edit_jenis_kelamin').val($(this).data('jenis_kelamin').toUpperCase()).trigger('change');
                    $('#edit_pendidikan').val($(this).data('pendidikan').toUpperCase()).trigger('change');
                    $('#edit_jumlah_kehadiran').val($(this).data('kehadiran'));
                    $('#edit_penilaian').val($(this).data('penilaian'));
                    $('#edit_jabatan').val($(this).data('jabatan').toUpperCase()).trigger('change');
                    $('#edit_produktivitas_kerja').val($(this).data('produktivitas_kerja').toUpperCase()).trigger('change');

                    const lamaBekerja = $(this).data('lama_bekerja');
                    if (lamaBekerja) {
                        const parts = lamaBekerja.trim().split(' ');
                        const angka = parts[0] || '';
                        const satuan = parts[1] || '';

                        $('#edit_lama_bekerja_angka').val(angka);
                        $('#edit_lama_bekerja_satuan').val(satuan.toUpperCase()).trigger('change');
                    } else {
                        $('#edit_lama_bekerja_angka').val('');
                        $('#edit_lama_bekerja_satuan').val('');
                    }

                    $('#formEditKaryawan').attr('action', `/karyawan/${id}`);
                });

                $(document).on('click', '.btn-hapus-karyawan', function(e){
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