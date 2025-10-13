<!DOCTYPE html>
<html>

<head>
    <title>Edit Note</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        form {
            max-width: 500px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        button {
            background: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>Edit Note</h1>

    <form action="/notes/{{ $note->id }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Title:</label>
            <input type="text" name="title" value="{{ old('title', $note->title) }}">
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Content:</label>
            <textarea name="content" rows="5">{{ old('content', $note->content) }}</textarea>
            @error('content')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Update Note</button>
        <a href="/notes">Cancel</a>
    </form>

</body>

</html>
