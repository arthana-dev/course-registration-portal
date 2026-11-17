<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Course Registration Portal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fb; }
        .navbar-brand { font-weight: 700; letter-spacing: .2px; }
        .hero { background: linear-gradient(120deg, #17365d, #2874a6); color: white; border-radius: 1rem; }
        .course-card { border: 0; border-radius: 1rem; box-shadow: 0 8px 24px rgba(20,40,70,.07); }
        .course-card .card-body { padding: 1.35rem; }
        .required-label::after { content: " *"; color: #dc3545; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#17365d">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Course Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <a class="nav-link" href="{{ route('home') }}">Courses</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a class="nav-link" href="{{ route('admin.courses.index') }}">Manage Courses</a>
                        <a class="nav-link" href="{{ route('admin.registrations.index') }}">Registrations</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light">Log out</button>
                    </form>
                @else
                    <a class="btn btn-sm btn-light" href="{{ route('login') }}">Admin Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<footer class="container py-4 text-center text-secondary small">
    Course Registration Portal · Full Stack Development Project
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
