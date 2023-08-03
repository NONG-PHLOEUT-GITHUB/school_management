<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ImportExelFileController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectTeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ========================authentication router=========================================

Route::post('/forgot-password', [ForgotPasswordController::class,'send_reset_password_email']);
Route::post('/reset-new-password/{token}', [ForgotPasswordController::class,'resetPassword']);
Route::post('/password/change', [ChangePasswordController::class,'change']);
Route::post('/sendPasswordResetLink', [ResetPasswordController::class, 'sendEmail']);

// ========================users router==================================================

Route::post('/users-import', [ImportExelFileController::class, 'import']);
Route::get('/teacher_information/{teacher_id}',[UserController::class,'getTeacherDetail']);
Route::get('/users/{id}', [UserController::class,"show"]);
Route::put('/users/{id}', [UserController::class,"update"]);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get("/show-graph-of-student-fail", [UserController::class, "getPercentageOfFaildedStudentByMonth"]);
Route::post('/getImage', [UserController::class, 'getImage']);
Route::get("/users/subject/{subject}", [UserController::class, "getTeacherBySubject"]);
Route::get('/get-teachers', [UserController::class,"getTeachers"]);

Route::delete('/get-teachers/{id}', [UserController::class,"destroy"]);
Route::get('/get-students', [UserController::class,"getStudent"]);

// ========================attendance router=============================================

Route::post("/attendances", [AttendanceController::class, 'store']);
Route::resource("/attendances", AttendanceController::class);

// ========================classroom router==============================================

Route::post("/classrooms", [ClassRoomController::class, 'store']);
Route::delete("/classrooms/{id}", [ClassRoomController::class, 'destroy']);
Route::put("/classrooms/{id}", [ClassRoomController::class, 'update']);
Route::get("/classrooms/{id}", [ClassRoomController::class, 'show']);
Route::get("/classrooms", [ClassRoomController::class, 'index']);
Route::get("/classrooms-total", [ClassRoomController::class, 'getTotalOfClass']);

Route::put('/classrooms/{id}', [UserController::class,"updateClass"]);
Route::post('/classroom', [ClassRoomController::class, 'store']);
Route::get('/getClassStudents', [ClassRoomController::class, 'getClassStudents']);
Route::get('/class_rooms/{id}', [ClassRoomController::class,"show"]);
Route::delete('/delete-user/{id}', [UserController::class,"destroy"]);
Route::get('/getuserInClass/{class}', [ClassRoomController::class, 'getClassNameUserId']);
Route::get('/get-students-in-class/{class}', [ClassRoomController::class, 'getClassNameTeacherId']);
Route::get('/get-students-by-class', [ClassRoomController::class, 'getClassName']);
Route::get('/getAllStudents/{class_id}', [ClassRoomController::class, 'getStudentsInClass']);
Route::get('/getTotalOfEachClass', [ClassRoomController::class, 'getTotalOfEachClass']);

// ========================subject router===============================================

Route::get('/subjects', [SubjectController::class, 'index']);
Route::post('/subjects', [SubjectController::class, 'store']);

// ========================comment router==============================================

Route::get('/getComments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);
Route::put("/comments", [CommentController::class, 'update']);
Route::get("/get-comments-student/{user_id}/{teacher_id}", [UserController::class, "getCommentForStudent"]);

// ========================score router=============================================

Route::get('/scores', [ScoreController::class, 'index']);
Route::post('/scores', [ScoreController::class, 'store']);
Route::get('/getStudentScoreEveryMonth/{user_id}', [ScoreController::class, 'getStudentScoreEveryMonth']);
Route::get('/getStudentScore/{id}/{month}', [ScoreController::class, 'getStudentScore']);

// ========================subject teachers router=================================== 

Route::get('/subjectsTeachers', [SubjectTeacherController::class, 'index']);
Route::post('/subjectsTeachers', [SubjectTeacherController::class, 'store']);

// ========================teachers router===========================================


// ========================Guardian router===========================================

Route::get("/getGuardian/{id}", [GuardianController::class,"getGuardianChatId"]);
Route::get("/getGuardians", [GuardianController::class,"index"]);
Route::get("/Guardians/{id}", [GuardianController::class,"show"]);
Route::post("/Guardians", [GuardianController::class,"store"]);
Route::put("/Guardians/{id}", [GuardianController::class,"update"]);
Route::delete("/Guardians/{id}", [GuardianController::class,"destroy"]);
Route::get("/getTotal", [UserController::class, "getTotalByRoleAndGender"]);
Route::get("/guardian/{id}", [UserController::class,"getUserIdFromGuardianId"]);
Route::get("/getParents/{id}", [UserController::class,"getParentsByuser"]);

// ========================attendance router===========================================

Route::get("/getAttendance", [AttendanceController::class, "getAttendanceListOfStudents"]);
Route::get("/get-most-absence-student", [AttendanceController::class, "getStudentMostAbsence"]);
Route::get("/getAttendance/{id}", [AttendanceController::class, "getAttendanceOfRole3ByUserId"]);
Route::get("/getStudentDetail/{id}", [AttendanceController::class, "showAttendanceDetail"]);
Route::get("/getteacherDetail/{id}", [AttendanceController::class, "getAttendanceOfRole2ByUserId"]);
Route::get("/getstudentattendanceeverymonth/{userId}", [AttendanceController::class, "getTotalAttendanceOfSpecificStudentAllMonths"]);
Route::post("/checkStudentAttendance", [AttendanceController::class, "store"]);
Route::get("/getTotalAbsentByMonth/{id}/{month}", [AttendanceController::class, "totalAbsentDaysByMonth"]);
Route::get("/getAbsentPercentageByMonth/{month}", [AttendanceController::class, "getAbsentPercentageByMonth"]);
Route::get("/show-grahp-of-student-attendance", [AttendanceController::class, "getTotalAttendanceOfStudentsAllMonths"]);
Route::get("/getTeacherAttendance", [AttendanceController::class, "getAttendanceListOfTeachers"]);
Route::get("/getTeacherMostAbsence", [AttendanceController::class, "getTeacherMostAbsence"]);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/getImage', [UserController::class, 'getImage']);
Route::get('/users/{id}', [UserController::class,"show"]);
Route::put('/users/{id}', [UserController::class,"update"]);
Route::resource('users' , UserController::class);
Route::get('/studentattendancedetail/{user_id}', [AttendanceController::class, 'showDetail']);
Route::post('/password/change', [ChangePasswordController::class,'change']);

Route::post('/sendPasswordResetLink', [ResetPasswordController::class, 'sendEmail']);
Route::get('/class_rooms/{id}', [ClassRoomController::class,"show"]);



Route::get('/getuserInClass/{class}', [ClassRoomController::class, 'getClassNameUserId']);

Route::get("/users/subject/{subject}", [UserController::class, "getTeacherBySubject"]);


Route::get('/getClassStudents', [ClassRoomController::class, 'getClassStudents']);

// get student
Route::get('/getStudents', [UserController::class,"getStudent"]);
Route::get('/getStudents/{id}', [UserController::class,"getStudentId"]);
Route::delete('/getStudents/{id}', [UserController::class,"destroy"]);

//   score
Route::get('/scores' , [ScoreController::class,"index"]);
Route::post('/scores' , [ScoreController::class,"store"]);

// get teachers
Route::get('/getTeachers', [UserController::class,"getTeachers"]);
Route::delete('/getTeachers/{id}', [UserController::class,"destroy"]);

Route::post('/forgot-password', [ForgotPasswordController::class,'send_reset_password_email']);
Route::post('/reset-password', [ForgotPasswordController::class,'resetPassword']);

// show detail attendance for specific student every month.
Route::get("/showAttendanceDetaileverymonth/{id}", [AttendanceController::class, "showAttendanceDetaileverymonth"]);

// ========================router=====================================================

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {

        // Login User
        Route::post('/login', [AuthenticationController::class, "login"]);

        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('/user', [AuthenticationController::class,'user']);

            // Logout user from application
            Route::post('/logout',[AuthenticationController::class,'logout']);
            // Change password user from application
        });
    });
});




