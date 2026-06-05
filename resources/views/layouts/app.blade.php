<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuacaTani - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        [data-theme="light"] {
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #212529;
            --navbar-bg: #198754;
            --table-bg: #ffffff;
            --border-color: #dee2e6;
        }
        [data-theme="dark"] {
            --bg-color: #1a1a2e;
            --card-bg: #16213e;
            --text-color: #e0e0e0;
            --navbar-bg: #0f3460;
            --table-bg: #16213e;
            --border-color: #444;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        .navbar { background-color: var(--navbar-bg) !important; }
        .card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-color);
        }
        .table {
            background-color: var(--table-bg);
            color: var(--text-color);
            border-color: var(--border-color);
        }
        .form-control, .form-select {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--border-color);
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--card-bg);
            color: var(--text-color);
        }
        #themeToggle { cursor: pointer; font-size: 1.2rem; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('lahan.index') }}">🌾 CuacaTani</a>
        <div class="ms-auto d-flex gap-2 align-items-center">
            <a href="{{ route('lahan.index') }}" class="btn btn-outline-light btn-sm">🌱 Data Lahan</a>
            <a href="{{ route('cuaca.index') }}" class="btn btn-outline-light btn-sm">🌤️ Cek Cuaca</a>
            <span id="themeToggle" onclick="toggleTheme()" title="Ganti Tema">🌙</span>
            <span class="text-white">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const current = html.getAttribute('data-theme');
        const next = current === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        document.getElementById('themeToggle').textContent = next === 'dark' ? '☀️' : '🌙';
    }

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.getElementById('themeToggle').textContent = savedTheme === 'dark' ? '☀️' : '🌙';
</script>
</body>
</html>