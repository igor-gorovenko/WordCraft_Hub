<!DOCTYPE html>
<html>

<head>
    <title>Word Craft Hub</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/main-5ffef9fa.css') }}">
</head>

<body>
    <div class="container">
        <h1><a href="{{ route('index') }}">Word Craft Hub</a></h1>
        @yield('content')
    </div>
</body>

</html>