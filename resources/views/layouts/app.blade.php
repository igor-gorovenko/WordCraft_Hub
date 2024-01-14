<!DOCTYPE html>
<html>

<head>
    <title>Word Craft Hub</title>
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    @include('components/header')

    <div class="d-flex " style="min-height: 100vh;">
        <div class="container mt-4 mb-4">
            @yield('content')
        </div>
    </div>

    @include('components/footer')
</body>

</html>