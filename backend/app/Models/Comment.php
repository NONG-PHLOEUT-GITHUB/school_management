<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'body',
        'user_id',
        'teacher_id',
    ];


    public static function store($request, $id = null)
    {
        $comments = $request->only(
            'id',
            'body',
            'user_id',
            'teacher_id'
        );
        if ($id) {
            $comment = self::find($id);
            if (!$comment) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $comment->update($comments);
        } else {
            $comment = self::create($comments);
            $id = $comment->$id;
            }
        
        // ================token user password=================
        return response()->json(['success' => true, 'data' => $comment], 201);
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id','id');
    }
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }

    public function getTeacherFullnameAttribute(){
        return $this->teacher->first_name.' '.$this->teacher->last_name;
    }
}
