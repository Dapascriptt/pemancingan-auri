<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Pemancingan AURI</title>
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <script src="{{ asset('assets/app.js') }}" defer></script>
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="brand admin-brand" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark">PA</span>
                <span>Admin AURI</span>
            </a>
            <nav class="admin-menu" aria-label="Navigasi admin">
                <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
                <a href="{{ route('admin.settings.edit') }}" @class(['active' => request()->routeIs('admin.settings.*')])>Home Settings</a>
                <a href="{{ route('admin.facilities.index') }}" @class(['active' => request()->routeIs('admin.facilities.*')])>Fasilitas</a>
                <a href="{{ route('admin.galleries.index') }}" @class(['active' => request()->routeIs('admin.galleries.*')])>Galeri</a>
                <a href="{{ route('admin.packages.index') }}" @class(['active' => request()->routeIs('admin.packages.*')])>Paket</a>
                <a href="{{ route('admin.participants.index') }}" @class(['active' => request()->routeIs('admin.participants.*')])>Peserta</a>
                <a href="{{ route('admin.contacts.edit') }}" @class(['active' => request()->routeIs('admin.contacts.*')])>Kontak</a>
            </nav>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline admin-logout" type="submit">Logout</button>
            </form>
        </aside>
        <main class="admin-main">
            <header class="admin-topbar">
                <div>
                    <p class="eyebrow">CMS Ringan</p>
                    <h1>@yield('title')</h1>
                </div>
                <a class="btn btn-ghost" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat Website</a>
            </header>
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
