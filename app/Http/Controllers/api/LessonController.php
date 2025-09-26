<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $course_id = $request->input('course_id');
        $limit = $request->input('limit', 25);
        $lesson = Lesson::with('course', 'quiz.question.answer');
        if ($id) {
            $lesson = $lesson->find($id);
            if (!$lesson) {
                return ResponseFormated::error(null, 'data lesson tidak ditemukan', 404);
            }
            return ResponseFormated::success($lesson, 'data lesson berhasil ditampilkan');
        }

        if ($course_id) {
            $lesson = $lesson->where('course_id', $course_id);
        }

        $lesson = $lesson->paginate($limit);

        return ResponseFormated::success($lesson, 'data lesson berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'numeric'],
            'body' => ['required', 'string'],
            'content_url' => ['nullable', 'url'],
        ]);
        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data lesson."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            Lesson::create($data);
            DB::commit();
            return ResponseFormated::success(null, 'data lesson berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'course_id' => ['required', 'numeric'],
            'body' => ['required', 'string'],
            'content_url' => ['nullable', 'url'],
        ]);
        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk mengubah data lesson."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return ResponseFormated::error(null, 'data lesson tidak ditemukan', 404);
            }
            $lesson->update($data);
            DB::commit();
            return ResponseFormated::success(null, 'data lesson berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menghapus data lesson."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return ResponseFormated::error(null, 'data lesson tidak ditemukan', 404);
            }
            $lesson->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data lesson berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
