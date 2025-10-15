<?php

namespace App\Http\Requests\Auth;

use App\Models\Karyawan;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $login = $this->input('login');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return [
                'login' => ['required', 'email'],
                'password' => ['required', 'string'],
            ];
        }

        return [
            'login' => ['required', 'string'],
            'password' => ['nullable', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $login = $this->input('login');
        $password = $this->input('password');

        if ($login && $password) {
            $credentials = ['email' => $login, 'password' => $password];
            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'login' => __('NIK atau PIN salah')
                ]);
            }
            return Auth::user();
        }

        $karyawan = Karyawan::where('nik', $login)->first();
        if (!$karyawan) {
            throw ValidationException::withMessages([
                'login' => __('NIK tidak ditemukan')
            ]);
        }

        if ($password && (!isset($karyawan->password) || !Hash::check($password, $karyawan->password))) {
            throw ValidationException::withMessages([
                'login' => __('Password salah')
            ]);
        }

        return null;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
