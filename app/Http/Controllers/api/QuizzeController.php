<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Question;
use App\Models\Quizze;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizzeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => ['required', 'numeric'],
            'title' => ['required', 'string'],
            'duration' => ['required', 'numeric'],

            'question' => ['required', 'array', 'min:1'],
            'question.*.question_text' => ['required', 'string'],
            'question.*.question_url' => ['nullable', 'url'],

            'question.*.answer' => ['required', 'array', 'min:1'],
            'question.*.answer.*.answer_text' => ['required', 'string'],
            'question.*.answer.*.is_correct' => ['required', 'in:true,false'],
        ]);

        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data quis."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $quiz = Quizze::create([
                'lesson_id' => $data['lesson_id'],
                'title' => $data['title'],
                'duration' => $data['duration'],
            ]);
            foreach ($data['question'] as $question) {
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
            DB::commit();
            return ResponseFormated::success(null, 'data quiz berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'lesson_id' => ['required', 'numeric'],
            'title' => ['required', 'string'],
            'duration' => ['required', 'numeric'],

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
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data quis."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $quiz = Quizze::find($id);
            if (!$quiz) {
                return ResponseFormated::error(null, 'data kuis tidak ditemukan', 404);
            }
            $quiz->update([
                'lesson_id' => $data['lesson_id'],
                'title' => $data['title'],
                'duration' => $data['duration'],
            ]);
            foreach ($data['question'] as $question) {
                $dataQuiz = Question::find($question['id']);
                if (!$dataQuiz) {
                    return ResponseFormated::error(null, 'data soal tidak ditemukan', 404);
                }
                $dataQuiz->update([
                    'question_text' => $question['question_text'],
                    'question_url' => isset($question['question_url']) ? $question['question_url'] : null,
                ]);
                foreach ($question['answer'] as $value) {
                    $answer = $dataQuiz->answer()->where('id', $value['id'])->first();
                    if (!$answer) {
                        return ResponseFormated::error(null, 'data jawaban tidak ditemukan', 404);
                    }
                    $answer->update([
                        'answer_text' => $value['answer_text'],
                        'is_correct' => $value['is_correct'],
                    ]);
                }
            }
            DB::commit();
            return ResponseFormated::success(null, 'data quiz berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
