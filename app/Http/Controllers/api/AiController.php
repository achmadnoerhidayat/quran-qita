<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function chat(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string|max:6000',
            'mode' => 'required|string|in:chat,tafsir',
        ]);

        try {
            $response = Http::timeout(60)->retry(3, 1000)->withHeaders([
                'Authorization' => 'Bearer ' . env('OPEN_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.openai.com/v1/responses', [
                'model' => env("OPENAI_MODEL"),
                'reasoning' => [
                    'effort' => 'low'
                ],
                'input' => [
                    [
                        'role' => 'system',
                        'content' => "Fokus pada penjelasan makna ayat dan konteks singkat, sertakan rujukan ringkas."
                    ],
                    [
                        'role' => 'user',
                        'content' => $data['question']
                    ],
                ],
            ]);

            if ($response->successful()) {
                $ai = $response->json();
                dd($ai);
            } else {
                dd($response->status(), $response->body());
            }
        } catch (\Exception $e) {
            return ResponseFormated::error(null, $e->getMessage(), 403);
            //throw $th;
        }
    }
}
