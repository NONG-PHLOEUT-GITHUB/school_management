<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassResource;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Caster\ClassStub;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = ClassRoom::all();
        return response()->json(['success' => true, 'data' => $classrooms], 200);
    }
    /**
     * Display a listing of the resource.
     */
    // public function getClassStudents(Request $request)
    // {
    //     $role = $request->query(3);
    //     $class = $request->query('10A');

    //     $class = ClassRoom::where('class_name', $class)
    //         ->whereHas('user_id', function ($query) use ($role) {
    //             $query->where('role', $role);
    //         })
    //         ->get();

    //     return $class;
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $classrooms = ClassRoom::store($request);
        return $classrooms;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classroom = ClassRoom::find($id);
        if (empty($classroom)) {
            return response()->json(['success' => false, 'message' => 'Undefined classroom id:' . $id], 401);
        }
        return response()->json(['success' => true, 'data' => $classroom], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $classroom = ClassRoom::store($request, $id);
        return response()->json(['success' => true, 'message' => 'classroom update successfully', 'data' => $classroom], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = ClassRoom::find($id);

        if (!$classroom) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        $classroom->delete();

        return response()->json(['success' => true, 'message' => 'classroom deleted successfully'], 200);
    }

    public function getClassNameUserId(string $className)
    {
        $classRooms = ClassRoom::where('class_name', $className)
            ->whereHas('students', function ($query) {
                $query->where('role', 3);
            })
            ->with('students')
            ->get();

        if ($classRooms->isEmpty()) {
            return "not found";
        } else {
            return response()->json(['success' => true, 'data' => $classRooms], 200);
        }
    }
    public function getStudentsInClass(string $id)
    {
        $classRooms = ClassRoom::where('id', $id)
            ->whereHas('students', function ($query) {
                $query->where('role', 3);
            })
            ->with([
                'students' => function ($query) {
                    $query->withCount('roleAttendances');
                    $query->orderByDesc('role_attendances_count');
                    $query->with([
                        'scores' => function ($query) {
                            $query->orderBy('subject_id', 'asc');
                        }
                    ]);
                }
            ])
            ->get();

        if ($classRooms->isEmpty()) {
            return "not found";
        } else {
            return response()->json(['success' => true, 'data' => $classRooms], 200);
        }
    }

    public function getClassNameTeacherId(string $className)
    {
        $classRooms = ClassRoom::where('class_name', $className)
            ->whereHas('students', function ($query) {
                $query->where('role', 2);
            })
            ->with('students')
            ->get();

        if ($classRooms->isEmpty()) {
            return "not found";
        } else {
            return response()->json(['success' => true, 'data' => $classRooms], 200);
        }
    }

    public function getTotalOfClass()
    {
        $classrooms = ClassRoom::count();
        return response()->json(['success' => true, 'data' => $classrooms], 200);
    }
    /**
     * Count of each class.
     */
    public function getTotalOfEachClass()
    {
        $classroomCounts = [
            '10' => ClassRoom::where('class_name', 'like', '10%')->count(),
            '11' => ClassRoom::where('class_name', 'like', '11%')->count(),
            '12' => ClassRoom::where('class_name', 'like', '12%')->count(),
        ];

        return response()->json(['success' => true, 'data' => $classroomCounts], 200);
    }
}