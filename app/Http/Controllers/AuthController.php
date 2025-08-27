<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'confirmed', // butuh field password_confirmation
                Password::min(8) // minimal 8 karakter
                    ->letters() // wajib ada huruf
                    ->mixedCase() // wajib ada huruf besar & kecil
                    ->numbers() // wajib ada angka
                    ->symbols(), // wajib ada simbol
            ],
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            DB::commit();
            return ResponseFormated::success($user, 'Register Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function login(Request $request)
    {
        // 1) Pastikan tidak terlalu banyak percobaan login (custom limiter)
        $this->ensureIsNotRateLimited($request);
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // 3) Cari user berdasarkan email
        $user = User::where('email', $data['email'])->first();

        // 4) Jika user tidak ada atau password salah -> hit rate limiter, lalu kirim error generik
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            // catat kegagalan login untuk throttle
            RateLimiter::hit($this->throttleKey($request), 60); // decay 60 detik
            throw ValidationException::withMessages([
                // pesan sengaja generik agar tidak memberikan petunjuk (prevent user enumeration)
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // 5) login sukses -> clear rate limiter untuk key tersebut
        RateLimiter::clear($this->throttleKey($request));

        // 6) OPTIONAL: hapus semua token lama (logout device lain)
        $user->tokens()->delete();
        $deviceName = 'API-' . md5($request->ip() . '|' . $request->header('User-Agent'));
        // 7) buat token baru untuk client (plainTextToken hanya ditampilkan sekali)
        $token = $user->createToken($deviceName)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'type' => "Bearer"
        ];
        return ResponseFormated::success($response, 'Login Successfully!');
    }

    public function loginGoogle(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string']
        ]);
        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $data['token'],
        ]);
        // Periksa respons dari Google
        if ($response->successful()) {
            $userData = $response->json();
            $email = $userData['email'];
            $appUser = User::where('email', $email)->first();
            if (!$appUser) {
                $appUser = User::create([
                    'name' => isset($userData['given_name']) ? $userData['given_name'] : $userData['name'],
                    'password' => bcrypt(Str::random(7)),
                    'email' => isset($email) ? $email : $userData['name'] . '@gmail.com',
                ]);
            }
            $user = User::where('id', $appUser->id)->first();
            $user->tokens()->delete();
            $deviceName = 'API-' . md5($request->ip() . '|' . $request->header('User-Agent'));
            // 7) buat token baru untuk client (plainTextToken hanya ditampilkan sekali)
            $token = $user->createToken($deviceName)->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
                'type' => "Bearer"
            ];

            return ResponseFormated::success($response, 'Access Token google Berhasil Ditampilkan');
        } else {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            throw ValidationException::withMessages([
                'email' => [__('Too many login attempts. Please try again later.')],
            ]);
        }
    }

    protected function throttleKey(Request $request)
    {
        // kombinasikan email + ip supaya throttle berlaku per-akun-per-ip
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
