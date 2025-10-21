<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LanggananController extends Controller
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
        $data = Subscription::with('user', 'plan')->orderBy('created_at', 'desc')->paginate(25);
        return view('langganan.index', [
            'data' => $data,
            'title' => 'Dashboard Langganan',
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
        $data = Subscription::with('user', 'plan')->find($id);
        return view('langganan.show', [
            'data' => $data,
            'title' => 'Dashboard Langganan',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "plan_id" => ['required', 'numeric'],
            "payment_status" => ['required', 'in:paid,failed'],
            "status" => ['nullable', 'in:pending,active,expired,cancelled'],
            "bukti_transfer" => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            "keterangan_admin" => ['required', 'string'],
        ]);
        $user = Auth::user();
        $url = null;
        $aksi = "Ditolak";
        try {
            DB::beginTransaction();
            $subs = Subscription::where('id', $id);
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                $subs = $subs->where('user_id', $user->id);
            }
            $subs = $subs->first();
            if (!$subs) {
                return response()->json([
                    'success' => false,
                    'message' => 'data subscription tidak ditemukan.'
                ]);
            }
            $url = $subs->bukti_transfer;
            if ($request->hasFile('bukti_transfer')) {
                Storage::disk('public')->delete($url);
                $photo = $request->file('bukti_transfer');
                $url = $photo->store('asset/subscription', 'public');
            }
            if ($data['payment_status'] === 'paid' && $subs->status === 'pending' && in_array($user->role, ['admin', 'super-admin'])) {
                $end = null;
                if ($subs->end_at !== null) {
                    $end = $subs->end_at->isPast() ? Carbon::now()->addDays($subs->plan->duration) : $subs->end_at->addDays($subs->plan->duration);
                } else {
                    $end = Carbon::now()->addDays($subs->plan->duration);
                    $data['starts_at'] = Carbon::now();
                }
                $aksi = "Dikonfirmasi";
                $data['end_at'] = $end;
                $data['status'] = "active";
            }
            $data['bukti_transfer'] = $url;
            $subs->update($data);
            $subs->detailSubscription()->create([
                "user_id" => $user->id,
                "aksi" => $aksi,
                "keterangan" => $data['keterangan_admin']
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data Langganan berhasil diupdate.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            "status" => ['required', 'in:pending,active,expired,cancelled'],
        ]);
        $user = Auth::user();
        try {
            DB::beginTransaction();
            $subs = Subscription::where('id', $id);
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                $subs = $subs->where('user_id', $user->id);
            }
            $subs = $subs->first();
            if (!$subs) {
                return response()->json([
                    'success' => false,
                    'message' => 'data subscription tidak ditemukan.'
                ]);
            }
            $subs->update($data);
            DB::commit();
            return redirect()->intended('/langganan');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
