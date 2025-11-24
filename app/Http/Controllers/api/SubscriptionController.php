<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\DuitkuService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            "payment_method" => ['required', 'string', 'max:2'],
        ]);
        try {
            $duitku = new DuitkuService();
            DB::beginTransaction();
            $plan = Plan::find($data['plan_id']);

            if (!$plan) {
                return ResponseFormated::error(null, 'data plan tidak ditemukan', 404);
            }

            $payment = $this->__listPayment($data['payment_method']);

            $orderId = 'QQS-' . Str::ulid();

            $params = [
                'paymentAmount'   => $plan->price,
                'paymentMethod'   => $data['payment_method'],
                'merchantOrderId' => $orderId,
                'productDetails'  => $plan->name,
                'email'           => $request->user()->email,
                'phoneNumber'     => '',
                'customerVaName'  => $request->user()->name,
                'expiryPeriod'    => 10,
                'callbackUrl'     => url('/api/subscription/callback'),
                'returnUrl'       => url('/paid-success'),
            ];

            $response = $duitku->createInvoice($params);
            $result = json_decode($response, true);

            Subscription::create([
                'user_id' => $request->user()->id,
                'plan_id' => $data['plan_id'],
                'order_id' => $orderId,
                'payment_reference' => $result['reference'],
                'va_number' => isset($result['vaNumber']) ? $result['vaNumber'] : null,
                'qr_string' => isset($result['qrString']) ? $result['qrString'] : null,
                'payment_url' => isset($result['paymentUrl']) ? $result['paymentUrl'] : null,
                'payment_method' => $data['payment_method'],
                'payment_type' => $payment['payment_type'],
                'information' => $payment['information'],
                'price' => $plan->price,
            ]);
            $result['order_id'] = $orderId;
            DB::commit();
            return ResponseFormated::success($result, 'data subscription berhasil ditambahkan');
        } catch (\Exception $e) {
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
            "payment_method" => ['required', 'string', 'max:2'],
        ]);

        $user = $request->user();
        try {
            $duitku = new DuitkuService();
            DB::beginTransaction();
            $sub = Subscription::where('user_id', $user->id)->first();
            if (!$sub) {
                return ResponseFormated::error(null, 'data Subscription tidak ditemukan', 404);
            }
            $plan = Plan::find($data['plan_id']);

            if (!$plan) {
                return ResponseFormated::error(null, 'data plan tidak ditemukan', 404);
            }

            $payment = $this->__listPayment($data['payment_method']);

            $orderId = 'QQS-' . Str::ulid();

            $params = [
                'paymentAmount'   => $plan->price,
                'paymentMethod'   => $data['payment_method'],
                'merchantOrderId' => $orderId,
                'productDetails'  => $plan->name,
                'email'           => $request->user()->email,
                'phoneNumber'     => '',
                'customerVaName'  => $request->user()->name,
                'expiryPeriod'    => 10,
                'callbackUrl'     => url('/api/subscription/callback'),
                'returnUrl'       => url('/paid-success'),
            ];

            $response = $duitku->createInvoice($params);
            $result = json_decode($response, true);
            $sub->update([
                'user_id' => $request->user()->id,
                'plan_id' => $data['plan_id'],
                'order_id' => $orderId,
                'payment_reference' => $result['reference'],
                'va_number' => isset($result['vaNumber']) ? $result['vaNumber'] : null,
                'qr_string' => isset($result['qrString']) ? $result['qrString'] : null,
                'payment_url' => isset($result['paymentUrl']) ? $result['paymentUrl'] : null,
                'payment_method' => $data['payment_method'],
                'payment_type' => $payment['payment_type'],
                'information' => $payment['information'],
                'price' => $plan->price,
                'status' => 'pending'
            ]);
            DB::commit();
            $result['order_id'] = $orderId;
            return ResponseFormated::success($result, 'data subscription berhasil diupgrade');
        } catch (\Exception $e) {
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

    public function callback(Request $request)
    {
        try {
            DB::beginTransaction();
            $duitku = new DuitkuService();
            $callback = $duitku->callback();

            // Log::info('Duitku Callback', $callback);

            // ---- Handle Status ----
            $subs = Subscription::where('order_id', $callback['merchantOrderId'])->where('status', 'pending')->first();
            if (!$subs) {
                return ResponseFormated::error(null, 'Langganan tidak ditemukan', 404);
            }
            if ($callback['resultCode'] == "00") {
                $end = null;
                $start = null;
                $note = null;
                if ($subs->end_at !== null) {
                    $end = $subs->end_at->isPast() ? Carbon::now()->addDays($subs->plan->duration) : $subs->end_at->addDays($subs->plan->duration);
                    $note = 'Perpanjang Langganan Berhasil';
                } else {
                    $end = Carbon::now()->addDays($subs->plan->duration);
                    $start = Carbon::now();
                    $note = 'Langganan Berhasil';
                }
                $subs->update([
                    'end_at' => $end,
                    'starts_at' => $start,
                    'status' => 'success'
                ]);
                $subs->detailSubscription()->create([
                    "user_id" => $request->user()->id,
                    "aksi" => 'Dikonfirmasi',
                    "keterangan" => $note
                ]);
            } else {
                $subs->update(['status' => 'failed']);
                $subs->detailSubscription()->create([
                    "user_id" => $request->user()->id,
                    "aksi" => 'Ditolak',
                    "keterangan" => 'Langganan Gagal'
                ]);
            }
            DB::commit();
            return ResponseFormated::success(null, 'ok');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Callback Error: " . $e->getMessage());
            return response($e->getMessage(), 400);
        }
    }

    private function __listPayment($methode)
    {
        $result = [];
        switch ($methode) {
            case 'VC':
                $result['payment_type'] = 'Credit Card';
                $result['information'] = '(Visa / Master Card / JCB)';
                break;
            case 'BC':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'BCA Virtual Account';
                break;
            case 'M2':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'Mandiri Virtual Account';
                break;
            case 'VA':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'Maybank Virtual Account';
                break;
            case 'I1':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'BNI Virtual Account';
                break;
            case 'B1':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'CIMB Niaga Virtual Account';
                break;
            case 'BT':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'Permata Bank Virtual Account';
                break;
            case 'A1':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'ATM Bersama';
                break;
            case 'AG':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'Bank Artha Graha';
                break;
            case 'NC':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'Bank Neo Commerce/BNC';
                break;
            case 'BR':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'BRIVA';
                break;
            case 'S1':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'Bank Sahabat Sampoerna';
                break;
            case 'DM':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'Danamon Virtual Account';
                break;
            case 'BV':
                $result['payment_type'] = 'Virtual Account';
                $result['information'] = 'BSI Virtual Account';
                break;
            case 'FT':
                $result['payment_type'] = 'Ritel';
                $result['information'] = 'Pegadaian/ALFA/Pos';
                break;
            case 'IR':
                $result['payment_type'] = 'Ritel';
                $result['information'] = 'Indomaret';
                break;
            case 'OV':
                $result['payment_type'] = 'E-Wallet';
                $result['information'] = 'OVO (Support Void)';
                break;
            case 'SA':
                $result['payment_type'] = 'E-Wallet';
                $result['information'] = 'Shopee Pay Apps (Support Void)';
                break;
            case 'LF':
                $result['payment_type'] = 'E-Wallet';
                $result['information'] = 'LinkAja Apps (Fixed Fee)';
                break;
            case 'LA':
                $result['payment_type'] = 'E-Wallet';
                $result['information'] = 'LinkAja Apps (Percentage Fee)';
                break;
            case 'DA':
                $result['payment_type'] = 'E-Wallet';
                $result['information'] = 'DANA';
                break;
            case 'SL':
                $result['payment_type'] = 'E-Wallet';
                $result['information'] = 'Shopee Pay Account Link';
                break;
            case 'OL':
                $result['payment_type'] = 'E-Wallet';
                $result['information'] = 'OVO Account Link';
                break;
            case 'SP':
                $result['payment_type'] = 'QRIS';
                $result['information'] = 'Shopee Pay';
                break;
            case 'NQ':
                $result['payment_type'] = 'QRIS';
                $result['information'] = 'Nobu';
                break;
            case 'GQ':
                $result['payment_type'] = 'QRIS';
                $result['information'] = 'Gudang Voucher';
                break;
            case 'SQ':
                $result['payment_type'] = 'QRIS';
                $result['information'] = 'Nusapay';
                break;
            case 'DN':
                $result['payment_type'] = 'Kredit';
                $result['information'] = 'Indodana Paylater';
                break;
            case 'AT':
                $result['payment_type'] = 'Kredit';
                $result['information'] = 'ATOME';
                break;

            default:
                $result['payment_type'] = 'E-Banking';
                $result['information'] = 'Jenius Pay';
                break;
        }
        return $result;
    }
}
