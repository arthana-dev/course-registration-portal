<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Course Registration Portal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="portal-shell">
<header class="portal-header">
    <nav class="portal-nav" aria-label="Main navigation">
        <div class="portal-container portal-nav-inner">
            <a class="portal-brand" href="{{ route('home') }}">
                <span class="portal-brand-mark" aria-hidden="true">CP</span>
                <span>Course <strong>Portal</strong></span>
            </a>
            <button class="portal-menu-toggle" type="button" aria-expanded="false" aria-controls="portalNavLinks" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
            <div class="portal-nav-links" id="portalNavLinks">
                <a href="{{ route('home') }}">Browse courses</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                        <a href="{{ route('admin.courses.index') }}">Manage courses</a>
                        <a href="{{ route('admin.registrations.index') }}">Registrations</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="portal-nav-action" type="submit">Log out</button>
                    </form>
                @else
                    <a class="portal-login-link" href="{{ route('login') }}">Admin login</a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<main class="portal-main">
    <div class="portal-container portal-page-wrap">
        @if(session('success'))
            <div class="portal-alert portal-alert-success" role="status">
                <span>{{ session('success') }}</span>
                <button type="button" class="portal-alert-close" aria-label="Dismiss message" data-bs-dismiss="alert">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="portal-alert portal-alert-error" role="alert">
                <strong>Please correct the following:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<footer class="portal-footer">
    <div class="portal-container portal-footer-inner">
        <a class="portal-footer-brand" href="{{ route('home') }}">Course Portal</a>
        <p>Practical learning, built around your next step.</p>
        <span>&copy; {{ date('Y') }} Course Registration Portal</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const menuToggle = document.querySelector('.portal-menu-toggle');
    const navLinks = document.getElementById('portalNavLinks');

    menuToggle?.addEventListener('click', () => {
        const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
        menuToggle.setAttribute('aria-expanded', String(!isExpanded));
        navLinks.classList.toggle('is-open', !isExpanded);
    });
</script>
@stack('scripts')
</body>
</html>
