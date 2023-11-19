<!DOCTYPE html>
<html>

<head>
    <title>Word List</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/main-5ffef9fa.css') }}">
</head>

<body>

    <h1>Word List</h1>
    <ul>
        @foreach($words as $word)
        <div>{{ $word->id }}. {{ $word->word }} - {{ $word->translation }}</div>
        @endforeach
    </ul>
    <button class="btn btn-primary">Save</button>
</body>

</html>