<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $guardian = Guardian::all();
        $guardian = UserResource::collection($guardian);
        return $guardian;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $guardian = Guardian::store($request);
        return $guardian;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guardian = Guardian::find($id);

        if (!$guardian) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $guardian], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,string $id)
    {
        $guardian = Guardian::store($request ,$id);
        return $guardian;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guardian = Guardian::find($id);
        $guardian->delete();
        return response()->json(['success' => true, 'data' => "delete successfully"], 200);
    }
    public function getGuardianChatId($id)
    {
        $guardian = Guardian::find($id);
        if (!$guardian) {
            return response()->json(['error' => 'Guardian not found'], 404);
        }
        return response()->json([
            "id" => $guardian->id,
            'chat_id' => $guardian->chatId
        ]);
    }
}
