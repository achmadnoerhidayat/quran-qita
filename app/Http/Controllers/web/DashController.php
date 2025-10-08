<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashController extends Controller
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
        $countPengguna = User::count();
        $priceSubcription = Subscription::with('plan')->get()->sum(function ($subscription) {
            return $subscription->plan->price;
        });
        $total = number_format($priceSubcription, 0, ',', '.');
        $subscription = Subscription::with('plan', 'user')->get();
        return view('home', [
            'subscription' => $subscription,
            'user' => $user,
            'count_user' => $countPengguna,
            'count_subs' => $total,
            'title' => 'Dashboard Quranqita',
            'class' => 'text-white bg-gray-700'
        ]);
    }
}
