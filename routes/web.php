<?php

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/notes', function () {

    $notes = Note::all();
    return view('notes.index', ['notes' => $notes]);
});

Route::get('/notes/create', function () {
    return view('notes.create');
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
