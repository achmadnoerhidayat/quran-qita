<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $plan_id = $request->input('plan_id');
        $user_id = $request->input('user_id');
        $status = $request->input('status');
        $limit = $request->input('limit', 20);
        $user = $request->user();

        if (!in_array($user->role, ['admin', 'super-admin'])) {
            if ($id) {
                $sub = Subscription::with('user', 'plan', 'detailSubscription')->where('id', $id)->where('user_id', $user->id)->first();
                if (!$sub) {
                    return ResponseFormated::error(null, 'data Subscription tidak ditemukan', 404);
                }
                return ResponseFormated::success($sub, 'data Subscription berhasil ditampilkan');
            }

            $sub = Subscription::with('user', 'plan', 'detailSubscription');
            if ($plan_id) {
                $sub = $sub->where('plan_id', $plan_id);
            }

            if ($status) {
                $sub = $sub->where('payment_status', $status);
            }

            $sub = $sub->where('user_id', $user->id)->first();

            return ResponseFormated::success($sub, 'data Subscription berhasil ditampilkan');
        } else {
            if ($id) {
                $sub = Subscription::with('user', 'plan', 'detailSubscription')->where('id', $id)->first();
                if (!$sub) {
                    return ResponseFormated::error(null, 'data Subscription tidak ditemukan', 404);
                }
                return ResponseFormated::success($sub, 'data Subscription berhasil ditampilkan');
            }

            $sub = Subscription::with('user', 'plan', 'detailSubscription');
            if ($plan_id) {
                $sub = $sub->where('plan_id', $plan_id);
            }

            if ($status) {
                $sub = $sub->where('payment_status', $status);
            }

            if ($user_id) {
                $sub = $sub->where('user_id', $user_id);
            }

            $sub = $sub->paginate($limit);

            return ResponseFormated::success($sub, 'data Subscription berhasil ditampilkan');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "plan_id" => ['required', 'numeric'],
            "bukti_transfer" => ['required', 'image', 'mimes:png,jpg,jpeg'],
        ]);
        $user = $request->user();
        $url = null;
        try {
            DB::beginTransaction();
            if ($request->hasFile('bukti_transfer')) {
                $photo = $request->file('bukti_transfer');
                $url = $photo->store('asset/subscription', 'public');
            }
            $data['user_id'] = $user->id;
            $data['payment_status'] = 'pending';
            $data['status'] = 'pending';
            $data['bukti_transfer'] = $url;
            $sub = Subscription::where('user_id', $user->id)->first();
            if ($sub) {
                $data['starts_at'] = null;
                $data['end_at'] = null;
                $sub->update($data);
            } else {
                Subscription::create($data);
            }
            DB::commit();
            return ResponseFormated::success(null, 'data subscription berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($url !== null) {
                Storage::disk('public')->delete($url);
            }
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "plan_id" => ['required', 'numeric'],
            "payment_status" => ['required', 'in:paid,failed'],
            "bukti_transfer" => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            "keterangan_admin" => ['required', 'string'],
        ]);
        $user = $request->user();
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
                return ResponseFormated::error(null, 'data subscription tidak ditemukan', 404);
            }
            $url = $subs->bukti_transfer;
            if ($request->hasFile('bukti_transfer')) {
                Storage::disk('public')->delete($url);
                $photo = $request->file('bukti_transfer');
                $url = $photo->store('asset/subscription', 'public');
            }
            if ($data['payment_status'] === 'paid' && $subs->status === 'pending' && in_array($user->role, ['admin', 'super-admin'])) {
                $aksi = "Dikonfirmasi";
                $end = $subs->end_at->isPast() ? Carbon::now()->addDays($subs->plan->duration) : $subs->end_at->addDays($subs->plan->duration);
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
            return ResponseFormated::success($subs, 'data subscription berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function renew(Request $request)
    {
        $data = $request->validate([
            "plan_id" => ['required', 'numeric'],
            "bukti_transfer" => ['required', 'image', 'mimes:png,jpg,jpeg'],
        ]);

        $user = $request->user();
        $url = null;
        try {
            DB::beginTransaction();
            $sub = Subscription::where('user_id', $user->id)->first();
            if (!$sub) {
                return ResponseFormated::error(null, 'data Subscription tidak ditemukan', 404);
            }
            $url = $sub->bukti_transfer;
            if ($request->hasFile('bukti_transfer')) {
                Storage::disk('public')->delete($url);
                $photo = $request->file('bukti_transfer');
                $url = $photo->store('asset/subscription', 'public');
            }
            $data['user_id'] = $user->id;
            $data['payment_status'] = 'pending';
            $data['status'] = 'pending';
            $data['bukti_transfer'] = $url;
            if ($sub) {
                $sub->update($data);
            }
            DB::commit();
            return ResponseFormated::success(null, 'data subscription berhasil diupgrade');
        } catch (\Exception $e) {
            if ($url !== null) {
                Storage::disk('public')->delete($url);
            }
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menghapus data subscription."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }
        $url = null;
        try {
            DB::beginTransaction();
            $subs = Subscription::where('id', $id)->first();
            if (!$subs) {
                return ResponseFormated::error(null, 'data subscription tidak ditemukan', 404);
            }
            $url = $subs->bukti_transfer;
            if ($url) {
                Storage::disk('public')->delete($url);
            }
            $subs->delete();
            $subs->detailSubscription()->delete();
            DB::commit();
            return ResponseFormated::success($subs, 'data subscription berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
