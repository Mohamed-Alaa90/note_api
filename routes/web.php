<?php

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $notes = Note::all();
    return view('notes.index', ['notes' => $notes]);
});

Route::get('/notes/create', function () {
    return view('notes.create');
});

Route::get('/notes/{id}/edit', function ($id) {
    $note = Note::findOrFail($id);
    return view('notes.edit', ['note' => $note]);
});

Route::get('/notes/{id}/delete', function ($id) {
    $note = Note::findOrFail($id);
    return view('notes.delete', ['note' => $note]);
});

Route::post('/notes', function (Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:225',
        'content' => 'required|string'
    ]);

    Note::create([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'user_id' => 2
    ]);

    return redirect('/notes');
});
Route::put('/notes/{id}', function (Request $request, $id) {
    $note = Note::findOrFail($id);
    $validated = $request->validate([
        'title' => 'required|string|max:225',
        'content' => 'required|string'
    ]);

    $note->update($validated);
    return redirect('/notes');
});

Route::delete('/notes/{id}', function (Request $request, $id) {
    $note = Note::findOrFail($id);
    $note->delete();
    return redirect('/notes');
});
