<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'score',
        'subject_id',
        'month',
        'user_id',
    ];

    public static function store($request, $id = null)
    {
        $scores = $request->only(
            'id',
            'score',
            'subject_id',
            'month',
            'user_id',
        );
        if ($id) {
            $score = self::find($id);
            if (!$score) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $score->update($scores);
        } else {
            $score = self::create($scores);
            $id = $score->$id;
        }   
        return $score;

        
    }
    public function subject(){
        return $this->hasOne(Subject::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}