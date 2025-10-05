<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $note = $request->user()->notes;
        return response()->json([
            'status' => 'success',
            'data' => [
                'notes' => $note
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string'
        ]);

        $note = $request->user()->notes()->create([
            'title' => $validated['title'],
            'content' => $validated['content']
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'note' => $note
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $note = $request->user()->notes()->find($id);

        if (!$note) {
            return response()->json([
                'status' => 'failure',
                'message' => 'note not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'note' => $note
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = $request->user()->notes()->find($id);
        if (!$note) {
            return response()->json([
                'message' => 'Note not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:225',
            "content" => 'sometimes|string'
        ]);

        $note->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Note updated successfully',
            'data' => [
                'note' => $note
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $note = $request->user()->notes()->find($id);
        if (!$note) {
            return response()->json([
                'status' => 'failure',
                'message' => 'note not found'
            ], 404);
        }

        $note->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Note deleted successfully',
        ], 200);
    }
}
