<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $limit = $request->input('limit', 20);
        $user = $request->user();

        if ($id) {
            $shedule = Schedule::with('user', 'surah', 'ayat')->where('id', $id)->where('user_id', $user->id)->first();
            if (!$shedule) {
                return ResponseFormated::error(null, 'data shedule tidak ditemukan', 404);
            }
            return ResponseFormated::success($shedule, 'data shedule berhasil ditampilkan');
        }

        $shedule = Schedule::with('user', 'surah', 'ayat');

        if ($title) {
            $shedule = $shedule->where('title', 'like', '%' . $title . '%');
        }

        $shedule = $shedule->where('user_id', $user->id)->paginate($limit);
        return ResponseFormated::success($shedule, 'data shedule berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "surah_id" => ['required', 'numeric'],
            "ayat_id" => ['nullable', 'numeric'],
            "title" => ['required', 'string'],
            "description" => ['required', 'string'],
            "scheduled_at" => ['required', 'date'],
            "recurrence_pattern" => ['required', 'in:harian,mingguan,bulanan'],
            "is_completed" => ['required', 'in:true,false'],
        ]);

        try {
            DB::beginTransaction();
            $data['user_id'] = $request->user()->id;
            $schedule = Schedule::create($data);
            DB::commit();
            return ResponseFormated::success($schedule, 'data schedule berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "surah_id" => ['required', 'numeric'],
            "ayat_id" => ['nullable', 'numeric'],
            "title" => ['required', 'string'],
            "description" => ['required', 'string'],
            "scheduled_at" => ['required', 'date'],
            "recurrence_pattern" => ['required', 'in:harian,mingguan,bulanan'],
            "is_completed" => ['required', 'in:true,false'],
        ]);

        try {
            DB::beginTransaction();
            $schedule = Schedule::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$schedule) {
                return ResponseFormated::error(null, 'data schedule tidak ditemukan', 404);
            }
            $schedule->update($data);
            DB::commit();
            return ResponseFormated::success($schedule, 'data schedule berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $schedule = Schedule::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$schedule) {
                return ResponseFormated::error(null, 'data schedule tidak ditemukan', 404);
            }
            $schedule->delete();
            DB::commit();
            return ResponseFormated::success($schedule, 'data schedule berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
