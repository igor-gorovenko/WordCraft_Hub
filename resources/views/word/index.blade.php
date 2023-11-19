<!DOCTYPE html>
<html>

<head>
    <title>Word List</title>
</head>

<body>
    <h1>Word List</h1>
    <ul>
        @foreach($words as $word)
        <div>{{ $word->id }}. {{ $word->word }} - {{ $word->translation }}</div>
        @endforeach
    </ul>
</body>

</html>