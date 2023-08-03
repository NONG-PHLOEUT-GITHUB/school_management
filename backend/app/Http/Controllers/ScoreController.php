<?php

namespace App\Http\Controllers;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scores = Score::all();
        return response()->json(['success' => true, 'data' => $scores], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $scores = Score::store($request);

        return response()->json(['success' => true, 'data' => $scores], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * get student score details.
     */
    public function getStudentScore(string $id, $month){

        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));

        $user_scores = Score::select('subjects.subject_name', 'scores.score', "month")
            ->join('users', 'scores.user_id', '=', 'users.id')
            ->join('subjects', 'scores.subject_id', '=', 'subjects.id')
            ->where('users.id', '=', $id)
            ->whereBetween('scores.month', [$startDate, $endDate])
            ->get();

        $total_score = 0;
        foreach ($user_scores as $score) {
            $total_score += $score->score;
        }
        $average_score = $total_score / 12;

        return response()->json([
            'user_id' => $id,
            'scores' => $user_scores,
            'total_score' => $total_score,
            'average_score' => $average_score,
        ], 200);
    }
    /**
     * get score of specific of student every month
     */
    public function getStudentScoreEveryMonth($userId){
        $averageScore = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = date('Y-m-01', strtotime(date('Y') . '-' . $month . '-01'));
            $endDate = date('Y-m-t', strtotime(date('Y') . '-' . $month . '-01'));
            $user_scores = Score::select('score')
                ->where('user_id', '=', $userId)
                ->whereBetween('month', [$startDate, $endDate])
                ->get();
            $total_score = 0;
            $num_scores = count($user_scores);
            foreach ($user_scores as $score) {
                $total_score += $score->score;
            }
            $average_score = ($num_scores > 0) ? $total_score / 12 : 0;
            $averageScore[date('F', mktime(0, 0, 0, $month, 1))] = $average_score;
        }
        return response()->json([
            'average_scores' => $averageScore,
        ], 200);
    }
}
