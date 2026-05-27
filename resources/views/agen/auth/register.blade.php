<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Agen — MobiTravel</title>
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
            --charcoal:  #1c1c1c;
            --ink:       #2e2e2e;
            --muted:     #7a7a6e;
            --error:     #c0392b;

            --font-display: 'Playfair Display', Georgia, serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'DM Mono', monospace;

            --ease-smooth: cubic-bezier(.25,.46,.45,.94);
            --ease-bounce: cubic-bezier(.34,1.56,.64,1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); background: var(--ivory); color: var(--ink); min-height: 100vh; }

        .nav {
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 4rem;
            background: rgba(245,240,232,.92);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 rgba(0,0,0,.08);
        }
        .nav__logo { font-family: var(--font-display); font-size: 1.5rem; font-weight: 900; color: var(--forest); letter-spacing: -.02em; }
        .nav__logo span { color: var(--gold); }
        .nav__links { display: flex; gap: 2.5rem; list-style: none; }
        .nav__links a { font-size: .875rem; font-weight: 500; letter-spacing: .04em; text-transform: uppercase; color: var(--ink); transition: color .2s; }
        .nav__links a:hover { color: var(--sage); }

        .container { max-width: 800px; margin: 0 auto; padding: 120px 20px 60px; }
        .card { background: white; border-radius: 1.25rem; padding: 2.5rem; box-shadow: 0 20px 60px rgba(26,51,40,.1); border: 1px solid var(--sand); }
        h1 { font-family: var(--font-display); font-size: 1.875rem; font-weight: 900; color: var(--forest); margin-bottom: .5rem; }
        .sub { color: var(--muted); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-family: var(--font-mono); font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: .4rem; }
        input, textarea, select { width: 100%; border: 1.5px solid var(--sand); border-radius: .65rem; padding: .75rem .9rem; font-family: var(--font-body); font-size: .9375rem; color: var(--ink); background: var(--ivory); outline: none; transition: all .2s; }
        input:focus, textarea:focus, select:focus { border-color: var(--sage); box-shadow: 0 0 0 3px rgba(78,128,96,.14); background: #fff; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        button { background: var(--forest); color: var(--cream); border: none; border-radius: .75rem; padding: .9rem; font-size: 1rem; font-weight: 700; cursor: pointer; width: 100%; transition: all .2s var(--ease-bounce); }
        button:hover { background: var(--moss); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,51,40,.25); }
        .error { background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 10px; margin-bottom: 20px; }
        .link { text-align: center; margin-top: 1.5rem; font-size: .875rem; color: var(--muted); }
        .link a { color: var(--terra); font-weight: 600; text-decoration: none; }
        @media (max-width: 640px) { .nav { padding: 1rem; } .row { grid-template-columns: 1fr; } .card { padding: 1.5rem; } }
    </style>
</head>
<body>

<nav class="nav">
    <div class="nav__logo">Mobi<span>Travel</span></div>
    <ul class="nav__links">
        <li><a href="/">Beranda</a></li>
        <li><a href="/agen">Agen</a></li>
    </ul>
</nav>

<div class="container">
    <div class="card">
        <h1>Daftar Agen Travel</h1>
        <p class="sub">Bergabunglah dan jangkau ribuan pelanggan</p>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('agen.register.post') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="form-group">
                    <label>NIK (16 digit) *</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required>
                    @error('nik') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Nama Agen *</label>
                    <input type="text" name="agency_name" value="{{ old('agency_name') }}" required>
                    @error('agency_name') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" required>
                    @error('password') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <label>Telepon *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required>
                    @error('phone') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>WhatsApp *</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required>
                    @error('whatsapp') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Kota *</label>
                    <input type="text" name="city" value="{{ old('city') }}" required>
                    @error('city') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Provinsi *</label>
                    <input type="text" name="province" value="{{ old('province') }}" required>
                    @error('province') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Alamat *</label>
                    <textarea name="address" rows="2" required>{{ old('address') }}</textarea>
                    @error('address') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Agen *</label>
                <textarea name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description') <small style="color:var(--error)">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Foto KTP *</label>
                <input type="file" name="ktp_photo" accept="image/jpeg,image/png,image/jpg" required>
                <small style="color:var(--muted)">Format: JPG, PNG. Maks 2MB</small>
                @error('ktp_photo') <small style="color:var(--error)">{{ $message }}</small> @enderror
            </div>

            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="{{ route('agen.login') }}">Login</a>
        </div>
    </div>
</div>

</body>
</html>