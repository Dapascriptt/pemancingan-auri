<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | Pemancingan AURI</title>
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <script src="{{ asset('assets/app.js') }}" defer></script>
</head>
<body class="admin-auth">
    <main class="login-shell">
        <section class="login-card">
            <span class="brand-mark">PA</span>
            <h1>Login Admin</h1>
            <p>Kelola konten one-page Pemancingan AURI.</p>
            <form method="POST" action="{{ route('login.store') }}" class="stack-form">
                @csrf
                <label>
                    Email
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email') <small class="form-error">{{ $message }}</small> @enderror
                </label>
                <label>
                    Password
                    <input type="password" name="password" required>
                    @error('password') <small class="form-error">{{ $message }}</small> @enderror
                </label>
                <label class="check-row">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>
                <button class="btn btn-primary" type="submit">Masuk</button>
            </form>
        </section>
    </main>
</body>
</html>
