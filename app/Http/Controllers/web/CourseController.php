<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $order = $request->input('order_by', 'desc');
        $limit = $request->input('limit', 25);
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = Course::with('lessons', 'quiz')->orderBy('created_at', $order)->paginate($limit);
        return view('course.index', [
            'data' => $data,
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
        $data = Course::find($id);
        return view('course.edit', [
            'data' => $data,
            'title' => 'Dashboard Learning',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        try {
            DB::beginTransaction();
            Course::create($data);
            DB::commit();
            return redirect()->intended('/course');
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        try {
            DB::beginTransaction();
            $course = Course::find($id);
            $course->update($data);
            DB::commit();
            return redirect()->intended('/course');
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
            $course = Course::find($id);
            if (!$course) {
                return response()->json([
                    'success' => false,
                    'message' => 'data kursus tidak ditemukan.'
                ]);
            }
            $course->delete();
            foreach ($course->quiz as $key => $quiz) {
                $quiz->delete();
                foreach ($quiz->question as $question) {
                    $question->delete();
                    $question->answer()->delete();
                }
            }
            $course->lessons()->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data kursus berhasil dihapus.'
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
