<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
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
        $data = Plan::orderBy('created_at', 'desc')->paginate(25);
        return view('plan.index', [
            'data' => $data,
            'title' => 'Dashboard Plan',
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
        $data = Plan::find($id);
        return view('plan.edit', [
            'data' => $data,
            'title' => 'Dashboard Plan',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'duration' => ['required', 'numeric'],
            'description' => ['required', 'string'],
        ]);

        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        try {
            DB::beginTransaction();
            $data['slug'] = Str::slug($data['name']);
            Plan::create($data);
            DB::commit();
            return redirect()->intended('/plan');
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
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'duration' => ['required', 'numeric'],
            'description' => ['required', 'string'],
        ]);

        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        try {
            DB::beginTransaction();
            $plan = Plan::find($id);
            if (!$plan) {
                return back()->withErrors([
                    'error' => 'plan tidak ditemukan',
                ]);
            }
            $data['slug'] = Str::slug($data['name']);
            $plan->update($data);
            DB::commit();
            return redirect()->intended('/plan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {

        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        try {
            DB::beginTransaction();
            $plan = Plan::find($id);
            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'message' => 'plan tidak ditemukan'
                ]);
            }
            $plan->delete();
            $plan->subscriptions()->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'plan berhasil dihapus'
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
