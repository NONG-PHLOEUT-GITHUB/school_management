<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = SubjectTeacher::all();
        return response()->json(['success' => true, 'data' => $subjects], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $subjects = SubjectTeacher::store($request);
        return response()->json(['success' => true, 'data' => $subjects], 201);
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
}
