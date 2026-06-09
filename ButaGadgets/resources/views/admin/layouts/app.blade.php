<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін-панель</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; min-height: 100vh; background-color: #f8f9fa; }
        .sidebar { width: 250px; background-color: #343a40; color: white; }
        .sidebar .nav-link { color: #c2c7d0; }
        .sidebar .nav-link.active { background-color: #495057; color: white; }
        .content { flex: 1; padding: 20px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-center mb-4">Панель адміна</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ Request::is('admin/products*') ? 'active' : '' }}">📦 Товари</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.directories.index') }}" class="nav-link {{ Request::is('admin/directories*') ? 'active' : '' }}">📂 Довідники (Бренди/Категорії)</a>
            </li>
            <li>
                <a href="{{ route('admin.comments.index') }}" class="nav-link {{ Request::is('admin/comments*') ? 'active' : '' }}">💬 Відгуки</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.specifications.index') }}" class="nav-link {{ Request::is('admin/specifications*') ? 'active' : '' }}">🛠 Конструктор характеристик</a>
            </li>
        </ul>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <script send="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>