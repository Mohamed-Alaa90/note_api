<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .note {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
        }

        .note h3 {
            margin: 0 0 10px 0;
        }
    </style>
    <title>Note</title>
</head>

<body>
    <h1>All notes</h1>
    <a href="/notes/create"
        style="display: inline-block; background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; margin-bottom: 20px;">
        Create New Note
    </a>
    @if ($notes->isEmpty())
        <p>No notes available.</p>
    @else
        @foreach ($notes as $note)
            <div class='note'>
                <h3>{{ $note->title }}</h3>
                <p>{{ $note->content }}</p>
            </div>
            <small>Created at: {{ $note->created_at }}</small>
        @endforeach
    @endif

</body>

</html>
