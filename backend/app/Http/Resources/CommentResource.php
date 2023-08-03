<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
            // 'teacher_firstname'=>$this->teacher->first_name ,
            // 'teacher_lastname'=>$this->teacher->last_name ,
            'teacher_fullname'=>$this->teacherFullname,
            'student_name'=>$this->student
        ];
    }
}
