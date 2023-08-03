<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\GuardianResource;
use App\Http\Resources\UserResource;
use App\Models\ClassRoom;
use App\Models\Comment;
use App\Models\Guardian;
use App\Models\Role;
use App\Models\Score;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::store($request);
        return $user;
    }


    public function getImage(StoreUserRequest $request)
    {
        $image = $request->file('profile');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        $path = asset('images/' . $new_name);
        return $path;
    }
    /**
     * Display the specified resource.
     */
    public function getEmails($id)
    {
        return User::select('email')->where('id', '!=', $id)->where('role', '!=', 'admin')->get();
    }
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id)
    {
        $user = User::store($request, $id);
        return $user;
    }

    /**
     * Remove the specified resource from storage.F
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
    }

    public function getTotalByRoleAndGender()
    {
        $maleCounts = [];
        $femaleCounts = [];

        $roles = [1, 2, 3]; // Set the roles for which you want to get the data

        foreach ($roles as $roleId) {
            $maleCount = User::where('role', $roleId)->where('gender', 'male')->count();
            $femaleCount = User::where('role', $roleId)->where('gender', 'female')->count();

            $maleCounts[$roleId] = $maleCount;
            $femaleCounts[$roleId] = $femaleCount;
        }

        $results = [];
        foreach ($roles as $roleId) {
            $results[] = [
                'role' => $roleId,
                'total' => $maleCounts[$roleId] + $femaleCounts[$roleId],
                'male' => $maleCounts[$roleId],
                'female' => $femaleCounts[$roleId]
            ];
        }

        return response()->json(['success' => true, 'data' => $results], 200);
    }


    public function getStudent()
    {
        $students = User::where('role', 3)
            ->select('*')
            ->get();
        return response()->json(["message" => true, "data" => $students], 200);
    }

    public function getTeachers()
    {
        $teachers = User::where('role', 2)
            ->select('*')
            ->get();
        return response()->json(["message" => true, "data" => $teachers], 200);
    }
    public function updateClass(Request $request, $id)
    {
        $classroom = ClassRoom::findOrFail($id);
        $classroom->update([
            'class_name' => $request->input('class_name'),
            'teacher_id' => $request->input('teacher_id'),
        ]);
        return response()->json([
            'message' => 'Classroom updated successfully',
            'classroom' => $classroom,
        ]);
    }
    public function getStudentId($id){
        $user = User::find($id);
        return response()->json($user);
    }
    public function getTeacherBySubject($subject)
    {
        $users = User::where('role', 2)
            ->join('subject_teachers', 'users.id', '=', 'subject_teachers.teacher_id')
            ->join('subjects', 'subject_teachers.subject_id', '=', 'subjects.id')
            ->where('subjects.subject_name', '=', $subject)
            ->select('users.*')
            ->get();
        if ($users) {
            return response()->json(["message" => "No teacher with subject " . $subject], 404);
        }
        return response()->json(["message" => true, "data" => $users], 200);
    }


    /**
     * show total of student failed of each month.
     */
    public function getPercentageOfFaildedStudentByMonth()
    {

        $users = User::where('role', '=', 3)->get();

        $failed_users = collect();

        foreach ($users as $user) {
            $user_scores = Score::select('subject_id', 'score')
                ->where('user_id', '=', $user->id)
                ->get();

            $total_score = 0;
            foreach ($user_scores as $score) {
                $total_score += $score->score;
            }
            $average_score = $total_score / 14;

            if ($average_score < 25.00) {
                $failed_users->push($user);
            }
        }

        $total_users = $users->count();
        $failed_users_count = $failed_users->count();
        $failed_users_percentage = [($failed_users_count / $total_users) * 100];

        $failed_users_male_count = $failed_users->where('gender', '=', 'male')->count();
        $failed_users_female_count = $failed_users->where('gender', '=', 'female')->count();

        return response()->json([
            'total_users' => $total_users,
            'failed_users_count' => $failed_users_count,
            'failed_users_percentage' => $failed_users_percentage,
            'failed_users_male_count' => $failed_users_male_count,
            'failed_users_female_count' => $failed_users_female_count,
        ], 200);


    }


    // ----------------------get comment for student------------------------
    
    public function getCommentForStudent($user_id, $teacher_id)
    {
        $comments = Comment::where('user_id', $user_id)
                    ->where('teacher_id', $teacher_id)
                    ->get();
        $comment = CommentResource::collection($comments);
        return response()->json(['comments' => $comment]);
    }

    public function getUserIdFromGuardianId($id)
    {
        $user = User::where('id', $id)->first();
        $guardian = Guardian::all();
        $guardian = GuardianResource::collection($guardian);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json([
            'user_id' => $user->id,
            'guardian_id' => $user->guardian->chatId ,
        ]);
    }

    public function getParentsByuser($id){
        $user = User::where('id', $id)->first();
        $guardian = Guardian::all();
        $guardian = GuardianResource::collection($guardian);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json([
            'user_id' => $user->id,
            'guardian' => $user->guardian,
        ]);
    }

}
