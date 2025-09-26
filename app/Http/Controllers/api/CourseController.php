<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $limit = $request->input('limit', 25);
        $course = Course::with('lessons.quiz.question.answer');
        if ($id) {
            $course = $course->where('id', $id)->first();
            if (!$course) {
                return ResponseFormated::error(null, 'data course tidak ditemukan', 404);
            }
            return ResponseFormated::success($course, 'data course berhasil ditampilkan');
        }
        if ($title) {
            $course = $course->where('title', 'like', '%' . $title . '%');
        }

        $course = $course->paginate($limit);
        return ResponseFormated::success($course, 'data course berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data course."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            Course::create($data);
            DB::commit();
            return ResponseFormated::success(null, 'data course berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk mengubah data course."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $course = Course::find($id);
            if (!$course) {
                return ResponseFormated::error(null, 'data course tidak ditemukan', 404);
            }
            $course->update($data);
            DB::commit();
            return ResponseFormated::success(null, 'data course berhasil diupdate');
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
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menghapus data course."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $course = Course::find($id);
            if (!$course) {
                return ResponseFormated::error(null, 'data course tidak ditemukan', 404);
            }
            $course->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data course berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
