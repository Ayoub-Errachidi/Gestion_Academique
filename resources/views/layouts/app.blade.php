<!DOCTYPE html>
<html>
<head>
    <title>Gestion Etudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="mb-4 text-center">Gestion des Etudiants</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</div>

</body>
</html>