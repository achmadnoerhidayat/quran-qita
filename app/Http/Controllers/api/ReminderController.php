<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $limit = $request->input('limit', 20);
        $user = $request->user();

        if ($id) {
            $reminder = Reminder::where('id', $id)->where('user_id', $user->id)->first();
            if (!$reminder) {
                return ResponseFormated::error(null, 'data reminder tidak ditemukan', 404);
            }
        }

        $reminder = Reminder::with('user');

        if ($title) {
            $reminder = $reminder->where('title', 'like', '%' . $title . '%');
        }

        $reminder = $reminder->where('user_id', $user->id)->paginate($limit);
        return ResponseFormated::success($reminder, 'data reminder berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => ['required', 'string'],
            "reminder_type" => ['required', 'in:sholat,dzikir,tahajud,puasa,lainnya'],
            "scheduled_at" => ['required', 'date'],
            "recurrence_pattern" => ['required', 'in:harian,mingguan,bulanan'],
            "is_active" => ['required', 'in:true,false'],
        ]);

        try {
            DB::beginTransaction();
            $data['user_id'] = $request->user()->id;
            $reminder = Reminder::create($data);
            DB::commit();
            return ResponseFormated::success($reminder, 'data reminder berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "title" => ['required', 'string'],
            "reminder_type" => ['required', 'in:sholat,dzikir,tahajud,puasa,lainnya'],
            "scheduled_at" => ['required', 'date'],
            "recurrence_pattern" => ['required', 'in:harian,mingguan,bulanan'],
            "is_active" => ['required', 'in:true,false'],
        ]);

        try {
            DB::beginTransaction();
            $reminder = Reminder::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$reminder) {
                return ResponseFormated::error(null, 'data reminder tidak ditemukan', 404);
            }
            $reminder->update($data);
            DB::commit();
            return ResponseFormated::success($reminder, 'data reminder berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $reminder = Reminder::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$reminder) {
                return ResponseFormated::error(null, 'data reminder tidak ditemukan', 404);
            }
            $reminder->delete();
            DB::commit();
            return ResponseFormated::success($reminder, 'data reminder berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
