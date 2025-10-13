<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quizze;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
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
        $data = Quizze::with('course', 'question')->orderBy('created_at', $order)->paginate($limit);
        $course = Course::all();
        return view('quiz.index', [
            'data' => $data,
            'course' => $course,
            'title' => 'Dashboard Learning',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function addQuestion($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        $data = Quizze::with('course', 'question.answer')->where('id', $id)->first();
        $course = Course::all();
        return view('quiz.add', [
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
            'title' => ['required', 'string'],
            'duration' => ['nullable', 'numeric'],
        ]);

        try {
            DB::beginTransaction();
            Quizze::create($data);
            DB::commit();
            return redirect()->intended('/kuis');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
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
        $data = Quizze::with('course', 'question')->find($id);
        $course = Course::all();
        return view('quiz.edit', [
            'data' => $data,
            'course' => $course,
            'title' => 'Dashboard Learning',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'course_id' => ['required', 'numeric'],
            'title' => ['required', 'string'],
            'duration' => ['nullable', 'numeric'],
        ]);

        try {
            DB::beginTransaction();
            $quiz = Quizze::find($id);
            if (!$quiz) {
                return back()->withErrors([
                    'error' => 'data materi tidak ditemukan',
                ]);
            }
            $quiz->update($data);
            DB::commit();
            return redirect()->intended('/kuis');
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
            $quiz = Quizze::find($id);
            if (!$quiz) {
                return response()->json([
                    'success' => false,
                    'message' => 'data materi tidak ditemukan.'
                ]);
            }
            $question = Question::where('quiz_id', $quiz->id)->get();
            $quiz->delete();
            if (count($question) > 0) {
                foreach ($question as $value) {
                    $value->delete();
                    $value->answer()->delete();
                }
            }
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

    public function addSoal(Request $request, $id)
    {
        $data = $request->validate([
            'question' => ['required', 'array', 'min:1'],
            'question.*.id' => ['required', 'numeric'],
            'question.*.question_text' => ['required', 'string'],
            'question.*.question_url' => ['nullable', 'url'],

            'question.*.answer' => ['required', 'array', 'min:1'],
            'question.*.answer.*.id' => ['required', 'numeric'],
            'question.*.answer.*.answer_text' => ['required', 'string'],
            'question.*.answer.*.is_correct' => ['required', 'in:true,false'],
        ]);
        try {
            DB::beginTransaction();
            $quiz = Quizze::find($id);
            foreach ($data['question'] as $question) {
                if (isset($question['id']) && $question['id'] !== '0') {
                    $dataQuiz = Question::find($question['id']);
                    $dataQuiz->update([
                        'quiz_id' => $quiz->id,
                        'question_text' => $question['question_text'],
                        'question_url' => isset($question['question_url']) ? $question['question_url'] : null,
                    ]);
                    foreach ($question['answer'] as $value) {
                        if (isset($value['id']) && $value['id'] !== '0') {
                            $dataAnswer = Answer::find($value['id']);
                            $dataAnswer->update([
                                'question_id' => $dataQuiz->id,
                                'answer_text' => $value['answer_text'],
                                'is_correct' => $value['is_correct'],
                            ]);
                        } else {
                            Answer::create([
                                'question_id' => $dataQuiz->id,
                                'answer_text' => $value['answer_text'],
                                'is_correct' => $value['is_correct'],
                            ]);
                        }
                    }
                } else {
                    $dataQuiz = Question::create([
                        'quiz_id' => $quiz->id,
                        'question_text' => $question['question_text'],
                        'question_url' => isset($question['question_url']) ? $question['question_url'] : null,
                    ]);
                    foreach ($question['answer'] as $value) {
                        $dataQuiz->answer()->create([
                            'answer_text' => $value['answer_text'],
                            'is_correct' => $value['is_correct'],
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->intended('/kuis');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function deleteSoal($id)
    {
        try {
            $quiz = Question::find($id);
            if (!$quiz) {
                return response()->json([
                    'success' => false,
                    'message' => 'soal tidak ditemukan.'
                ]);
            }
            DB::beginTransaction();
            $quiz->delete();
            $quiz->answer()->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'soal berhasil dihapus.'
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
