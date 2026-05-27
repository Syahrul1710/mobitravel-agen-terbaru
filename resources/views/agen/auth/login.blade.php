<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Agen — MobiTravel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest:    #1a3328;
            --moss:      #2d5a3d;
            --sage:      #4e8060;
            --mist:      #a8c5b0;
            --cream:     #f5f0e8;
            --ivory:     #faf8f3;
            --sand:      #e8dfc8;
            --terra:     #c17f3b;
            --gold:      #e8a83e;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'DM Mono', monospace;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); background: var(--ivory); min-height: 100vh; display: flex; align-items: center; justify-content: center; }

        .nav {
            position: fixed; top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            padding: 1.25rem 4rem;
            background: rgba(245,240,232,.92);
            backdrop-filter: blur(12px);
        }
        .nav__logo { font-family: var(--font-display); font-size: 1.5rem; font-weight: 900; color: var(--forest); }
        .nav__logo span { color: var(--gold); }

        .card { background: white; border-radius: 1.25rem; padding: 2.5rem; width: 100%; max-width: 450px; margin: 0 20px; border: 1px solid var(--sand); box-shadow: 0 20px 60px rgba(26,51,40,.1); }
        h1 { font-family: var(--font-display); font-size: 1.875rem; font-weight: 900; color: var(--forest); margin-bottom: .5rem; text-align: center; }
        .sub { color: var(--muted); text-align: center; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-family: var(--font-mono); font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: .4rem; }
        input { width: 100%; border: 1.5px solid var(--sand); border-radius: .65rem; padding: .75rem .9rem; font-family: var(--font-body); font-size: .9375rem; outline: none; transition: all .2s; }
        input:focus { border-color: var(--sage); box-shadow: 0 0 0 3px rgba(78,128,96,.14); }
        button { background: var(--forest); color: var(--cream); border: none; border-radius: .75rem; padding: .9rem; font-size: 1rem; font-weight: 700; cursor: pointer; width: 100%; transition: all .2s; }
        button:hover { background: var(--moss); transform: translateY(-2px); }
        .error { background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 10px; margin-bottom: 20px; }
        .link { text-align: center; margin-top: 1.5rem; font-size: .875rem; color: var(--muted); }
        .link a { color: var(--terra); font-weight: 600; text-decoration: none; }

        @media (max-width: 640px) { .nav { padding: 1rem; } .card { padding: 1.5rem; } }
    </style>
</head>
<body>

<nav class="nav">
    <div class="nav__logo">Mobi<span>Travel</span></div>
    <div></div>
</nav>

<div class="card">
    <h1>Login Agen</h1>
    <p class="sub">Masuk ke dashboard agen Anda</p>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('agen.login.post') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <small style="color:#c0392b">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password') <small style="color:#c0392b">{{ $message }}</small> @enderror
        </div>

        <button type="submit">Login →</button>
    </form>

    <div class="link">
        Belum punya akun? <a href="{{ route('agen.register') }}">Daftar Sekarang</a>
    </div>
</div>

</body>
</html>