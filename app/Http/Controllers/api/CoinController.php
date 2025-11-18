<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\CoinPackage;
use App\Models\CoinPurchase;
use App\Models\CoinTransaction;
use App\Models\UserWallet;
use App\Services\DuitkuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CoinController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 25);
        $user = $request->user();
        $wallet = UserWallet::with('user');
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            $wallet = $wallet->where('user_id', $user->id)->first();
            if (!$wallet) {
                return ResponseFormated::error(null, 'data user coin tidak ditemukan', 404);
            }
            $purchase = CoinPurchase::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            $history = CoinTransaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            $wallet['purchase'] = $purchase;
            $wallet['history'] = $history;
            return ResponseFormated::success($wallet, 'data user coin berhasil ditampilkan');
        }
        if ($id) {
            $wallet = $wallet->where('id', $id)->first();
            if (!$wallet) {
                return ResponseFormated::error(null, 'data user coin tidak ditemukan', 404);
            }
            $purchase = CoinPurchase::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            $history = CoinTransaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            $wallet['purchase'] = $purchase;
            $wallet['history'] = $history;
            return ResponseFormated::success($wallet, 'data user coin berhasil ditampilkan');
        }

        $wallet = $wallet->orderBy('created_at', 'desc')->paginate($limit);
        return ResponseFormated::success($wallet, 'data user coin berhasil ditampilkan');
    }

    public function purchase(Request $request)
    {
        $id = $request->input('id');
        $order_id = $request->input('order_id');
        $limit = $request->input('limit', 20);
        $user = $request->user();
        $purchase = CoinPurchase::with('user', 'package');
        if ($id) {
            $purchase = $purchase->find($id);
            if (!$purchase) {
                return ResponseFormated::error(null, 'data pembelian tidak ditemukan', 404);
            }
        }
        if ($order_id) {
            $purchase = $purchase->where('order_id', $order_id);
        }
        $purchase = $purchase->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate($limit);
        return ResponseFormated::success($purchase, 'data pembelian berhasil ditampilkan');
    }

    public function topup(Request $request)
    {
        $data = $request->validate([
            'package_id' => ['required', 'numeric'],
            'payment_method' => ['required', 'string', 'max:2'],
        ]);

        try {
            $duitku = new DuitkuService();
            DB::beginTransaction();
            $paket = CoinPackage::find($data['package_id']);

            if (!$paket) {
                return ResponseFormated::error(null, 'data paket tidak ditemukan', 404);
            }

            $amount = 0;

            if ($paket->bonus_coin > 0) {
                $amount = $paket->coin_amount + $paket->bonus_coin;
            } else {
                $amount = $paket->coin_amount;
            }

            $payment = $this->__listPayment($data['payment_method']);

            $orderId = 'QQC-' . Str::ulid();

            $params = [
                'paymentAmount'   => $paket->price,
                'paymentMethod'   => $data['payment_method'],
                'merchantOrderId' => $orderId,
                'productDetails'  => 'Topup ' . $paket->coin_amount,
                'email'           => $request->user()->email,
                'phoneNumber'     => '',
                'customerVaName'  => $request->user()->name,
                'expiryPeriod'    => 10,
                'callbackUrl'     => url('/api/coin/callback'),
                'returnUrl'       => url('/paid-success'),
            ];

            $response = $duitku->createInvoice($params);
            $result = json_decode($response, true);
            CoinPurchase::create([
                'user_id' => $request->user()->id,
                'package_id' => $data['package_id'],
                'amount_coin' => $amount,
                'order_id' => $orderId,
                'payment_reference' => $result['reference'],
                'va_number' => isset($result['vaNumber']) ? $result['vaNumber'] : null,
                'qr_string' => isset($result['qrString']) ? $result['qrString'] : null,
                'payment_method' => $data['payment_method'],
                'payment_type' => $payment['payment_type'],
                'information' => $payment['information'],
                'price' => $paket->price,
            ]);
            $result['order_id'] = $orderId;
            DB::commit();
            return ResponseFormated::success($result, 'topup coin berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function cekTransaksi(Request $request)
    {
        $data = $request->validate([
            'order_id' => ['required']
        ]);

        $purchase = CoinPurchase::where('order_id', $data['order_id'])->where('user_id', $request->user()->id)->first();
        if (!$purchase) {
            return ResponseFormated::error(null, 'data top up coin tidak ditemukan', 404);
        }
        $duitku = new DuitkuService();
        $status = $duitku->checkStatus($data['order_id']);
        return ResponseFormated::success(json_decode($status, true), 'data status transaksi berhasil ditampilkan');
    }

    public function callback(Request $request)
    {
        try {
            DB::beginTransaction();
            $duitku = new DuitkuService();
            $callback = $duitku->callback();

            Log::info('Duitku Callback', $callback);

            // ---- Handle Status ----
            $coin = CoinPurchase::where('order_id', $callback['merchantOrderId'])->first();
            if (!$coin) {
                return ResponseFormated::error(null, 'topup coin tidak ditemukan', 404);
            }
            if ($callback['resultCode'] == "00") {
                $coin->update(['status' => 'success']);
                // tambah saldo user
                $wallet = UserWallet::where('user_id', $coin->user_id)->first();
                if (!$wallet) {
                    UserWallet::create([
                        'user_id' => $coin->user_id,
                        'coins' => $coin->amount_coin,
                    ]);
                    // tambah coin transaksi
                    CoinTransaction::create([
                        'user_id' => $coin->user_id,
                        'purchase_id' => $coin->id,
                        'end_balance' => $coin->amount_coin,
                        'amount_coin' => $coin->amount_coin,
                    ]);
                } else {
                    $amount = (int) $coin->amount_coin + (int) $wallet->coins;
                    $wallet->update([
                        'coins' => $amount,
                    ]);

                    CoinTransaction::create([
                        'user_id' => $coin->user_id,
                        'purchase_id' => $coin->id,
                        'start_balance' => $wallet->coins,
                        'end_balance' => $amount,
                        'amount_coin' => $coin->amount_coin,
                    ]);
                }
            } else {
                $coin->update(['status' => 'failed']);
            }
            DB::commit();
            return ResponseFormated::success(null, 'ok');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Callback Error: " . $e->getMessage());
            return response($e->getMessage(), 400);
        }
    }

    public function paymentMethode(Request $request)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric']
        ]);
        $duitku = new DuitkuService();
        $payment = $duitku->paymentMethode($data['amount']);
        return ResponseFormated::success($payment['paymentFee'], 'data list pembayaran berhasil ditampilkan');
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
