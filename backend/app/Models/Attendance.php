<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'status',
        'reason',
        'date',
        'user_id',
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public static function store($request, $id = null)
    {
        $attendances = $request->only(
            'id',
            'status',
            'reason',
            'date',
            'user_id',
        );

        if ($id) {
            $attendance = self::find($id);
            if (!$attendance) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $attendance->update($attendances);
        } else {
            $attendance = self::create($attendances);
            $id = $attendance->$id;
        }

        return response()->json(['success' => true, 'data' => $attendances], 201);
    }
}
