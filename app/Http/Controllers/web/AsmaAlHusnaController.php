<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\AsmaulHusna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsmaAlHusnaController extends Controller
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
        $data = AsmaulHusna::paginate($limit);
        return view('asma.index', [
            'data' => $data,
            'title' => 'Dashboard Asma Al Husna',
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
        $data = AsmaulHusna::find($id);
        if (!$data) {
            return back()->withErrors([
                'error' => 'data dzikir tidak ditemukan',
            ]);
        }
        return view('asma.edit', [
            'data' => $data,
            'title' => 'Dashboard Dzikir',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'arab' => ['required'],
            'latin' => ['required'],
            'indo' => ['required'],
        ]);
        try {
            DB::beginTransaction();
            AsmaulHusna::create($data);
            DB::commit();
            return redirect()->intended('/asma');
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
            'arab' => ['required'],
            'latin' => ['required'],
            'indo' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $asma = AsmaulHusna::find($id);
            if (!$asma) {
                return back()->withErrors([
                    'error' => 'data dzikir tidak ditemukan',
                ]);
            }

            $asma->update($data);
            DB::commit();
            return redirect()->intended('/asma');
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
            $asma = AsmaulHusna::find($id);
            if (!$asma) {
                return response()->json([
                    'success' => false,
                    'message' => 'data asma tidak ditemukan.'
                ]);
            }
            $asma->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data asma berhasil dihapus.'
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
