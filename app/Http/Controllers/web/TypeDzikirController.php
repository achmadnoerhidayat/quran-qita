<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\TypeDzikir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TypeDzikirController extends Controller
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
        $data = TypeDzikir::paginate($limit);
        return view('typeDzikir.index', [
            'data' => $data,
            'title' => 'Dashboard Dzikir',
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
        $data = TypeDzikir::find($id);
        if (!$data) {
            return back()->withErrors([
                'error' => 'data type dzikir tidak ditemukan',
            ]);
        }
        return view('typeDzikir.edit', [
            'data' => $data,
            'title' => 'Dashboard Dzikir',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            TypeDzikir::create($data);
            DB::commit();
            return redirect()->intended('/type-dzikir');
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
            'name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $dzikir = TypeDzikir::find($id);
            if (!$dzikir) {
                return back()->withErrors([
                    'error' => 'data type dzikir tidak ditemukan',
                ]);
            }
            $dzikir->update($data);
            DB::commit();
            return redirect()->intended('/type-dzikir');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $dzikir = TypeDzikir::find($id);
            if (!$dzikir) {
                return response()->json([
                    'success' => false,
                    'message' => 'data type dzikir tidak ditemukan.'
                ]);
            }
            $dzikir->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data type dzikir berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
