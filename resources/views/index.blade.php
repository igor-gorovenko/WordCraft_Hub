<!DOCTYPE html>
<html>

<head>
    <title>Word List</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/main-5ffef9fa.css') }}">
</head>

<body>
    <div class="container">
        <h1>Word List</h1>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Word</th>
                    <th>Translation</th>
                    <th>Usage Count</th>
                    <th>Usage %</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalWords = count($words);
                @endphp

                @foreach($words as $word)
                <tr>
                    <td>{{ $word->id }}</td>
                    <td>{{ $word->word }}</td>
                    <td>{{ $word->translation }}</td>
                    <td>{{ $word->usage_count }}</td>
                    <td>{{ number_format(($word->usage_count / $totalWords) / 100, 2) }} %</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>