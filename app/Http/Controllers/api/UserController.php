<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 25);
        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            $users = User::with('followers.follower', 'followings.following')->where('id', $user->id)->first();
            if (!$users) {
                return ResponseFormated::error(null, 'data user tidak ditemukan', 404);
            }
            return ResponseFormated::success($users, 'data user berhasil ditampilkan');
        }
        if ($id) {
            $users = User::with('followers.follower', 'followings.following')->where('id', $id)->first();
            if (!$users) {
                return ResponseFormated::error(null, 'data user tidak ditemukan', 404);
            }
            return ResponseFormated::success($users, 'data user berhasil ditambahkan');
        }

        $users = User::with('followers.follower', 'followings.following');
        if ($name) {
            $users = $users->where('name', 'like', '%' . $name . '%');
        }
        return ResponseFormated::success($users->paginate($limit), 'data user berhasil ditampilkan');
    }

    public function store(Request $request)
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

        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data user baru."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }

        try {
            DB::beginTransaction();
            $users = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            DB::commit();
            return ResponseFormated::success($users, 'data user berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => [
                'nullable',
                'confirmed', // butuh field password_confirmation
                Password::min(8) // minimal 8 karakter
                    ->letters() // wajib ada huruf
                    ->mixedCase() // wajib ada huruf besar & kecil
                    ->numbers() // wajib ada angka
                    ->symbols(), // wajib ada simbol
            ],
        ]);

        $id_user = $id;

        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            $id_user = $user->id;
        }

        try {
            DB::beginTransaction();
            $users = User::where('id', $id_user)->first();
            if (!$users) {
                return ResponseFormated::error(null, 'data user tidak ditemukan', 404);
            }
            $users->name = $data['name'];
            $users->email = $data['email'];
            if (isset($data['password'])) {
                $users->password = Hash::make($data['password']);
            }
            $users->save();
            DB::commit();
            return ResponseFormated::success($users, 'data user berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        $id_user = $id;

        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data user baru."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }

        try {
            DB::beginTransaction();
            $users = User::where('id', $id_user)->first();
            if (!$users) {
                return ResponseFormated::error(null, 'data user tidak ditemukan', 404);
            }
            $users->delete();
            $users->bookmark()->delete();
            $users->forum()->delete();
            DB::commit();
            return ResponseFormated::success($users, 'data user berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function updateFcmToken(Request $request)
    {
        $data = $request->validate([
            'device_id' => ['required', 'string']
        ]);
        $user = User::where('id', $request->user()->id)->first();
        $user->update([
            'device_id' => $data['device_id']
        ]);
        return ResponseFormated::success(null, 'data device token berhasil ditambahkan');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg']
        ]);
        $user = $request->user();
        $url = null;
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $url = $photo->store('asset/user', 'public');
        }
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->update([
            'image' => $url
        ]);

        return ResponseFormated::success(null, 'berhasil upload profile');
    }
}
