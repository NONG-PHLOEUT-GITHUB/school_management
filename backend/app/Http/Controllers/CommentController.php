<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::all();
        $comment = CommentResource::collection($comment);
        return response()->json(['success' => true, 'data' => $comment], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::store($request);
        return response()->json(['success' => true, 'data' => $comment], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        return response()->json(['success' => true, 'data' => $comment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::store($request, $id);

        return response()->json(['success' => true, 'data' => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::store($id);
        $comment->delete();
        return response()->json(['success' => true, 'date' => "delete successfully"], 200);
    }
}