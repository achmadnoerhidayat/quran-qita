<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $order = $request->input('order_by', 'desc');
        $limit = $request->input('limit', 20);
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $course = Course::all();
        $data = Lesson::with('course')->orderBy('created_at', $order)->paginate($limit);
        return view('lesson.index', [
            'data' => $data,
            'course' => $course,
            'title' => 'Dashboard Learning',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $course = Course::all();
        $data = Lesson::find($id);
        return view('lesson.edit', [
            'data' => $data,
            'course' => $course,
            'title' => 'Dashboard Learning',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'numeric'],
            'body' => ['required', 'string'],
            'content_url' => ['nullable', 'url'],
        ]);

        try {
            DB::beginTransaction();
            Lesson::create($data);
            DB::commit();
            return redirect()->intended('/lesson');
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
            'course_id' => ['required', 'numeric'],
            'body' => ['required', 'string'],
            'content_url' => ['nullable', 'url'],
        ]);

        try {
            DB::beginTransaction();
            $lesson = Lesson::find($id);
            $lesson->update($data);
            DB::commit();
            return redirect()->intended('/lesson');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return response()->json([
                    'success' => false,
                    'message' => 'data materi tidak ditemukan.'
                ]);
            }
            $lesson->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data materi berhasil dihapus.'
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
