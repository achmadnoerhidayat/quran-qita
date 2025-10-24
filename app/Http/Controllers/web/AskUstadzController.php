<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\AskUstadz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AskUstadzController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = AskUstadz::with('user')->orderBy('created_at', 'desc')->paginate(25);
        return view('ustadz.index', [
            'data' => $data,
            'title' => 'Dashboard Tanya Ustadz',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'jawaban' => ['required', 'string']
        ]);
        try {
            DB::beginTransaction();
            $ustad = AskUstadz::find($id);
            if (!$ustad) {
                return response()->json([
                    'success' => false,
                    'message' => 'data tanya ustad tidak ditemukan.'
                ]);
            }
            $data['status'] = 'dijawab';
            $ustad->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data tanya ustad berhasil diupdate.'
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
