<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 25);
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = User::orderBy('name', 'asc')->paginate($limit);
        return view('user.index', [
            'data' => $data,
            'title' => 'Dashboard Pengguna',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = User::find($id);
        if (!$data) {
            return back()->withErrors([
                'error' => 'data user tidak ditemukan',
            ]);
        }

        return view('user.show', [
            'data' => $data,
            'title' => 'Dashboard Pengguna',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:admin,user,super-admin'],
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
            User::create($data);
            DB::commit();
            return redirect()->intended('/user');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:admin,user,super-admin'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        try {
            $user = User::find($id);
            DB::beginTransaction();
            $user->update($data);
            DB::commit();
            return redirect()->intended('/user');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
