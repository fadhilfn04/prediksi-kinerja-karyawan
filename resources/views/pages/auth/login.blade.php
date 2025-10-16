<x-auth-layout>
    <!--begin::Heading-->
    <div class="text-center mb-11"> 
        <h1 class="text-gray-900 fw-bolder mb-3">Halo, Selamat Datang!</h1> 
        <div class="text-gray-600 fw-semibold fs-6">Taufik Hidayat · 5520124031102</div> 
    </div>
    <!--end::Heading-->


    <!-- Tabs -->
    <div class="d-flex justify-content-center mb-6">
        <button type="button" class="btn btn-light-primary me-2 tab-btn active" data-target="formAdmin">Admin</button>
        <button type="button" class="btn btn-light-success tab-btn" data-target="formKaryawan">Karyawan</button>
    </div>

    <!--begin::Form Admin-->
    <form class="form w-100 login-form" id="formAdmin" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="fv-row mb-8">
            <input type="text" placeholder="NIK" name="login" autocomplete="off"
                class="form-control bg-transparent @error('login') is-invalid @enderror"/>
            @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off"
                class="form-control bg-transparent @error('password') is-invalid @enderror"/>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary">Masuk</button>
        </div>
    </form>
    <!--end::Form Admin-->

    <!--begin::Form Karyawan-->
    <form class="form w-100 login-form" id="formKaryawan" style="display:none;">
        @csrf
        <div class="fv-row mb-8">
            <input type="text" placeholder="NIK" name="login" autocomplete="off"
                class="form-control bg-transparent @error('login') is-invalid @enderror"/>
            @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-success">Lihat Prediksi Saya</button>
        </div>

        <!-- Hasil Prediksi -->
        <div id="prediksiResult" class="card mt-4 shadow-sm" style="display:none;">
            <div class="card-header">
                <h3 class="card-title fw-bold">Hasil Prediksi Anda</h3>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> <span id="prediksiNama"></span></p>
                <p><strong>Jabatan:</strong> <span id="prediksiJabatan"></span></p>
                <p><strong>Pendidikan:</strong> <span id="prediksiPendidikan"></span></p>
                <p><strong>Prediksi Kinerja:</strong> <span id="prediksiStatus" class="badge"></span></p>

                <div id="pretestLinkWrapper" class="mt-4" style="display:none;">
                    <a href="https://linktr.ee/AlfamartBandung1" class="btn btn-sm btn-light-danger w-100">
                        Ikuti Pretest Sekarang
                    </a>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form Karyawan-->

    <!--begin::Sign up-->
    <div class="text-gray-500 text-center fw-semibold fs-6 mt-4">
        Belum punya akun? <a href="{{ route('register') }}" class="link-primary">Daftar Sekarang</a>
    </div>
    <!--end::Sign up-->

    @push('scripts')
    <script>
        const tabs = document.querySelectorAll('.tab-btn');
        const forms = document.querySelectorAll('.login-form');
        const prediksiCard = document.getElementById('prediksiResult');

        // Switch tabs
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                forms.forEach(f => f.style.display = 'none');
                document.getElementById(tab.dataset.target).style.display = 'block';
                prediksiCard.style.display = 'none';
            });
        });

        // Karyawan AJAX login
        const formKaryawan = document.getElementById('formKaryawan');
        formKaryawan.addEventListener('submit', function(e){
            e.preventDefault();
            prediksiCard.style.display = 'none';

            const formData = new FormData(formKaryawan);

            fetch("{{ route('login') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    // Karyawan type
                    prediksiCard.style.display = 'block';
                    document.getElementById('prediksiNama').innerText = data.karyawan.nama;
                    document.getElementById('prediksiJabatan').innerText = data.prediksi.jabatan;
                    document.getElementById('prediksiPendidikan').innerText = data.prediksi.pendidikan_terakhir;
                    const badge = document.getElementById('prediksiStatus');
                    badge.innerText = data.prediksi.prediksi;
                    badge.className = 'badge ' + (data.prediksi.prediksi == 'Baik' ? 'bg-success' :
                        data.prediksi.prediksi == 'Cukup' ? 'bg-warning' : 'bg-danger');

                    const pretestLinkWrapper = document.getElementById('pretestLinkWrapper');
                    if (data.prediksi.prediksi === 'Kurang') {
                        pretestLinkWrapper.style.display = 'block';
                    } else {
                        pretestLinkWrapper.style.display = 'none';
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: data.message || 'Terjadi kesalahan.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Terjadi kesalahan server.',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
    @endpush
</x-auth-layout>
