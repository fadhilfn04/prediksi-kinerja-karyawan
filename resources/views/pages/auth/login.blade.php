<x-auth-layout>
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
        data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <h1 class="text-gray-900 fw-bolder mb-3">
                Sistem Prediksi Kinerja Karyawan
            </h1>
            <div class="text-gray-600 fw-semibold fs-6">
                Zona 3 Bandung Barat · Algoritma Decision Tree
            </div>
        </div>
        <!--end::Heading-->

        <!--begin::Input group-->
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" autocomplete="off"
                class="form-control bg-transparent @error('email') is-invalid @enderror"
                value="{{ old('email') }}"/>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off"
                class="form-control bg-transparent @error('password') is-invalid @enderror"/>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => 'Masuk'])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="link-primary">Daftar Sekarang</a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->
</x-auth-layout>