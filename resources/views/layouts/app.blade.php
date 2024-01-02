<!DOCTYPE html>
<html>

<head>
    <title>Word Craft Hub</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/main-5ffef9fa.css') }}">
</head>

<body>
    @include('components/header')
    <div class="container mt-2">
        @yield('content')
    </div>
</body>

</html>