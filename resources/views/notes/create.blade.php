<!DOCTYPE html>
<html>

<head>
    <title>Create Note</title>
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
            background: #4CAF50;
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
    <h1>Create New Note</h1>

    <form action="/notes" method="POST">
        @csrf

        <div>
            <label>Title:</label>
            <input type="text" name="title" value="{{ old('title') }}">
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Content:</label>
            <textarea name="content" rows="5">{{ old('content') }}</textarea>
            @error('content')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Create Note</button>
        <a href="/notes">Cancel</a>
    </form>

</body>

</html>
