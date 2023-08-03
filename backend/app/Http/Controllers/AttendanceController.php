<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
// use \Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = Attendance::all();
        return response()->json(['success' => true, 'data' => $attendance], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        //
        $attendance = Attendance::store($request);
        return $attendance;
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $id)
    {
        $attendance = Attendance::find($id);

        return response()->json(['success' => true, 'data' => $attendance], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
        $attendance = Attendance::store($request, $id);
        return response()->json(['success' => true, 'data' => $attendance], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'Attendance not found'], 404);
        }
        $attendance->delete();
        return response()->json(['success' => true, 'message' => 'Attendance deleted successfully'], 200);
    }
    /**
     * Get attendance list of students.
     */
    public static function getAttendanceListOfStudents()
    {
        $users = User::where('role', 3)
            ->select('id', 'first_name', 'last_name', 'class_room_id')
            ->withCount('roleAttendances')
            ->get();
        return response()->json($users);
    }
    /**
     * Get five students that most absence.
     */
    public static function getStudentMostAbsence()
    {
        $users = User::where('role', 3)
            ->select('*')
            ->withCount('roleAttendances')
            ->orderByDesc('role_attendances_count', 'desc')
            ->limit(10)
            ->get();
        return response()->json($users);
    }
    /**
     * Get attendance list of teachers.
     */
    public static function getAttendanceListOfTeachers()
    {
        $users = User::where('role', 2)
            ->select('id', 'first_name', 'last_name')
            ->withCount('roleAttendances')
            ->get();
        return response()->json($users);
    }
    /**
     * Get five teacher that most absence.
     */
    public static function getTeacherMostAbsence()
    {
        $users = User::where('role', 2)
            ->select('id', 'first_name', 'last_name')
            ->withCount('roleAttendances')
            ->orderByDesc('role_attendances_count')
            ->limit(5)
            ->get();
        return response()->json($users);
    }
    /**
     * show attendance of student detail .
     */
    public function showAttendanceDetail($id)
    {
        $attendance = Attendance::findOrFail($id);

        return response()->json([
            'date' => $attendance->date,
            'reason' => $attendance->reason,
            'attendance_status' => $attendance->attendace_status,
        ]);
    }
    /**
     * get attendance of student detail .
     */
    public static function getAttendanceOfRole3ByUserId($id)
    {
        $user = User::where('role', 3)
            ->find($id);

        if ($user) {
            $attendanceRecords = $user->roleAttendances;
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                ],
                'attendanceRecords' => $attendanceRecords,
            ]);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    /**
     * get attendance of teacher detail .
     */
    public static function getAttendanceOfRole2ByUserId($id)
    {
        $user = User::where('role', 2)
            ->find($id);

        if ($user) {
            $attendanceRecords = $user->roleAttendances;
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                ],
                'attendanceRecords' => $attendanceRecords,
            ]);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    /**
     * show average of student attendance of each month.
     */
    public function getAbsentPercentageByMonth($month)
    {
        // Calculate the start and end date of the given month
        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));

        // Get the total number of attendance records for all students in the given month
        $totalAttendance = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->where('users.role', 3)
            ->whereBetween('date', [$startDate, $endDate])
            ->count();

        // Get the number of absent attendance records for all students in the given month
        $absentAttendance = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->where('users.role', 3)
            ->where('attendances.attendance_status', 'absent')
            ->whereBetween('month', [$startDate, $endDate])
            ->count();

        // Calculate the absent percentage for all students in the given month
        $absentPercentage = ($absentAttendance / $totalAttendance) * 100;

        // Return the absent percentage as a JSON response
        return response()->json(['absentPercentage' => $absentPercentage], 200);
    }
    /**
     * show total of student failed of each month.
     */
    public function getPercentageOfFaildedStudentByMonth()
    {
        $percentage = [];
        return response()->json(['data' => $percentage], 200);
    }
    /**
     * show total of student absent of each month.
     */
    public function totalAbsentDaysByMonth($user_id, $month)
    {
        $month = Carbon::createFromFormat('Y-m', $month);
        $absentAttendances = Attendance::where('user_id', $user_id)
            ->where('attendance_status', 'absent')
            ->whereMonth('date', $month->month)
            ->whereYear('date', $month->year)
            ->get();
        $totalAbsentDays = count($absentAttendances);

        if (empty($totalAbsentDays)) {
            return response()->json(['message' => "No absent this month"], 404);
        }
        return response()->json(['totalAbsentDays' => $totalAbsentDays]);
    }
    /**
     * show total of students absent of all month.
     */
    public function getTotalAttendanceOfStudentsAllMonths()
    {
        $attendanceCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalAttendance = User::where('role', 3)
                ->whereHas('roleAttendances', function ($query) use ($month) {
                    $query->whereMonth('date', $month);
                })
                ->count();
            $attendanceCounts[date('F', mktime(0, 0, 0, $month, 1))] = $totalAttendance;
        }
        return response()->json($attendanceCounts);
    }
    /**
     * show total of specific student absent of all month.
     */
    public function getTotalAttendanceOfSpecificStudentAllMonths($userId)
    {
        $attendanceCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalAttendance = User::where('id', $userId)
                ->whereHas('roleAttendances', function ($query) use ($month) {
                    $query->whereMonth('date', $month);
                })
                ->with([
                    'roleAttendances' => function ($query) use ($month) {
                        $query->whereMonth('date', $month);
                    }
                ])
                ->get()
                ->pluck('roleAttendances')
                ->flatten()
                ->unique('id')
                ->count();
            $attendanceCounts[date('F', mktime(0, 0, 0, $month, 1))] = $totalAttendance;
        }
        return response()->json($attendanceCounts);
    }
}