<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\QuizResponse;
use App\Models\Quizze;
use App\Models\User;
use App\Models\UserScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizzeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'numeric'],
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
                'course_id' => $data['course_id'],
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
            'course_id' => ['required', 'numeric'],
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
                'course_id' => $data['course_id'],
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

    public function start(Request $request)
    {
        $data = $request->validate([
            'quiz_id' => ['required', 'numeric'],
        ]);
        try {
            DB::beginTransaction();
            $quiz = Quizze::find($data['quiz_id']);
            if (!$quiz) {
                return ResponseFormated::error(null, 'data quiz tidak ditemukan', 404);
            }
            $start = Carbon::now();
            $end = Carbon::now()->addMinute($quiz->duration);
            $record = QuizAttempt::where('user_id', $request->user()->id)->where('quiz_id', $data['quiz_id'])->first();
            $attemp_id = null;
            if (!$record) {
                $attemp = QuizAttempt::create([
                    'user_id' => $request->user()->id,
                    'quiz_id' => $data['quiz_id'],
                    'start_time' => $start,
                    'end_time' => $end,
                ]);
                $attemp_id = $attemp->id;
            } else {
                $record->update([
                    'user_id' => $request->user()->id,
                    'quiz_id' => $data['quiz_id'],
                    'start_time' => $start,
                    'end_time' => $end,
                    'status' => 'started'
                ]);
                $attemp_id = $record->id;
            }
            $dataAtemp = QuizAttempt::with('user', 'quiz.question.answer')->where('id', $attemp_id)->first();
            DB::commit();
            return ResponseFormated::success($dataAtemp, 'data kuis berhasil dimulai');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'attempt_id' => ['required', 'numeric'],
            'answer' => ['required', 'array', 'min:1'],
            'answer.*.question_id' => ['required', 'numeric'],
            'answer.*.answer_id' => ['required', 'numeric'],
        ]);

        $user = $request->user();
        $attemp = QuizAttempt::where('id', $data['attempt_id'])->where('user_id', $user->id)->where('end_time', '>', Carbon::now())->first();
        if (!$attemp) {
            return ResponseFormated::error(null, 'anda belm memulai kuis atau batas waktu pengerjaan sudah habis harap call start quiz ulang', 403);
        }
        $totalQuestion = count($attemp->quiz->question);
        $correctCount = 0;
        $incorrectCount = 0;
        if ($totalQuestion !== count($data['answer'])) {
            return ResponseFormated::error(null, 'Gagal menyimpan jawaban. Jumlah soal tidak lengkap. Silakan coba submit ulang.', 422);
        }
        $userScore = UserScore::where('attempt_id', $attemp->id)->first();
        if ($userScore) {
            if ((int) $userScore->percentage === 100) {
                return ResponseFormated::success(null, 'Selamat! Anda sudah menguasai materi ini dengan skor sempurna (100%). Lanjut ke pelajaran/kursus berikutnya!');
            }
        }

        foreach ($data['answer'] as $answer) {
            $dataAnswer = Answer::find($answer['answer_id']);
            if (!$dataAnswer) {
                return ResponseFormated::error(null, 'data answer tidak ditemukan', 404);
            }
            if ($dataAnswer->is_correct === 'true') {
                $correctCount++;
            } else {
                $incorrectCount++;
            }
            $dataQuestion = Question::find($answer['question_id']);
            if (!$dataQuestion) {
                return ResponseFormated::error(null, 'data Question tidak ditemukan', 404);
            }
            $resp = QuizResponse::where('attempt_id', $data['attempt_id'])->where('question_id', $answer['question_id'])->first();
            if (!$resp) {
                QuizResponse::create([
                    'attempt_id' => $data['attempt_id'],
                    'question_id' => $answer['question_id'],
                    'answer_id' => $answer['answer_id'],
                    'is_correct' => $dataAnswer->is_correct
                ]);
            } else {
                $resp->update([
                    'attempt_id' => $data['attempt_id'],
                    'question_id' => $answer['question_id'],
                    'answer_id' => $answer['answer_id'],
                    'is_correct' => $dataAnswer->is_correct
                ]);
            }
        }

        $attemp->status = 'submited';
        $attemp->save();

        $percentage = ($correctCount / $totalQuestion) * 100;
        $finalPercentage = round($percentage, 2);
        if (!$userScore) {
            UserScore::create([
                'attempt_id' => $attemp->id,
                'score' => $correctCount,
                'percentage' => $finalPercentage,
            ]);
        } else {
            $userScore->update([
                'attempt_id' => $attemp->id,
                'score' => $correctCount,
                'percentage' => $finalPercentage,
            ]);
        }
        $attemp->status = 'graded';
        $attemp->save();

        return ResponseFormated::success([
            'correct' => $correctCount,
            'in_correct' => $incorrectCount,
            'score' => $correctCount,
            'percentage' => $finalPercentage,
            'total_questions' => $totalQuestion
        ], 'berhasil kirim jawaban quiz');
    }

    public function result(Request $request)
    {
        $id = $request->input('id');
        $quiz_id = $request->input('quiz_id');
        $limit = $request->input('limit', 10);
        $attemp = QuizAttempt::with('quiz.question.answer', 'quizResponse.question', 'quizResponse.answer', 'user', 'userScore');
        if ($id) {
            $attemp = $attemp->where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$attemp) {
                return ResponseFormated::error(null, 'data ujian tidak ditemukan', 404);
            }
            return ResponseFormated::success($attemp, 'data ujian berhasil ditampilkan');
        }
        if ($quiz_id) {
            $attemp = $attemp->where('quiz_id', $quiz_id);
        }
        $attemp = $attemp->where('user_id', $request->user()->id)->paginate($limit);
        return ResponseFormated::success($attemp, 'data ujian berhasil ditampilkan');
    }

    public function leaderboard()
    {
        $userScores = UserScore::all();
        $totalScores = [];
        foreach ($userScores as $scoreRecord) {
            $userId = $scoreRecord->attemp->user_id;
            $points = $scoreRecord->percentage * 1;
            if (isset($totalScores[$userId])) {
                $totalScores[$userId] += $points;
            } else {
                $totalScores[$userId] = $points;
            }
        }
        arsort($totalScores);

        $leaderboard = [];
        $rank = 1;

        foreach ($totalScores as $userId => $totalXp) {
            $leaderboard[] = [
                'rank' => $rank++,
                'total_xp' => $totalXp,
                'user' => User::find($userId),
            ];
        }
        return ResponseFormated::success($leaderboard, 'data leaderboard berhasil ditampilkan');
    }
}
