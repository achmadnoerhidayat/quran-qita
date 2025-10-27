<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Dzikir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DzikirController extends Controller
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
        $data = Dzikir::paginate($limit);
        return view('dzikir.index', [
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
        $data = Dzikir::find($id);
        if (!$data) {
            return back()->withErrors([
                'error' => 'data dzikir tidak ditemukan',
            ]);
        }
        return view('dzikir.edit', [
            'data' => $data,
            'title' => 'Dashboard Dzikir',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required'],
            'arab' => ['required'],
            'indo' => ['required'],
            'ulang' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            Dzikir::create($data);
            DB::commit();
            return redirect()->intended('/dzikir');
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
            'type' => ['required'],
            'arab' => ['required'],
            'indo' => ['required'],
            'ulang' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $dzikir = Dzikir::find($id);
            if (!$dzikir) {
                return back()->withErrors([
                    'error' => 'data dzikir tidak ditemukan',
                ]);
            }
            $dzikir->update($data);
            DB::commit();
            return redirect()->intended('/dzikir');
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
            $dzikir = Dzikir::find($id);
            if (!$dzikir) {
                return response()->json([
                    'success' => false,
                    'message' => 'data dzikir tidak ditemukan.'
                ]);
            }
            $dzikir->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data dzikir berhasil dihapus.'
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
