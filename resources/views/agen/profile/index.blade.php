<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Agen - MobiTravel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f0e8;
            color: #2e2e2e;
        }
        
        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: #1a3328;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px 0;
            overflow-y: auto;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.5rem;
            color: #e8a83e;
        }
        .sidebar-menu {
            list-style: none;
        }
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #a8c5b0;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover {
            background: #2d5a3d;
            color: white;
        }
        .sidebar-menu a.active {
            background: #4e8060;
            color: white;
            border-left: 4px solid #e8a83e;
        }
        .logout-btn {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 12px 20px;
            color: #a8c5b0;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 30px;
        }
        .logout-btn:hover {
            background: #2d5a3d;
            color: white;
        }
        
        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        
        /* CARD */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e8dfc8;
        }
        .card-header h2 {
            color: #1a3328;
            font-size: 1.5rem;
        }
        
        /* FORM */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1a3328;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #e8dfc8;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-control:focus {
            outline: none;
            border-color: #4e8060;
        }
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        /* BUTTONS */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: #1a3328;
            color: white;
        }
        .btn-primary:hover {
            background: #2d5a3d;
        }
        .btn-warning {
            background: #e8a83e;
            color: #1a3328;
        }
        .btn-danger {
            background: #dc2626;
            color: white;
        }
        
        /* ALERT */
        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        /* LOGO PREVIEW */
        .logo-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e8a83e;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<!-- SIDEBAR -->
<div class="sidebar">
    <h2>MobiTravel</h2>
    <ul class="sidebar-menu">
        <li><a href="{{ route('agen.dashboard') }}" class="@yield('menu-dashboard', '')">Dashboard</a></li>
        <li><a href="{{ route('agen.destinations.index') }}" class="@yield('menu-destinasi', '')">Destinasi</a></li>
        <li><a href="{{ route('agen.tour-packages.index') }}" class="@yield('menu-paket', '')">Paket Wisata</a></li>
        <li><a href="{{ route('agen.bookings.index') }}" class="@yield('menu-pemesanan', '')">Pemesanan</a></li>
        <li><a href="{{ route('agen.profile.index') }}" class="@yield('menu-profil', '')">Profil</a></li>
    </ul>
    <form method="POST" action="{{ route('agen.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Edit Profil -->
    <div class="card">
        <div class="card-header">
            <h2>Edit Profil Agen</h2>
        </div>
        
        <form action="{{ route('agen.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="form-group">
                    <label>Nama Agen *</label>
                    <input type="text" name="agency_name" class="form-control" value="{{ old('agency_name', $agent->agency_name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $agent->email) }}" required>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Telepon *</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $agent->phone) }}" required>
                </div>
                <div class="form-group">
                    <label>WhatsApp *</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $agent->whatsapp) }}" required>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Kota *</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $agent->city) }}" required>
                </div>
                <div class="form-group">
                    <label>Provinsi *</label>
                    <input type="text" name="province" class="form-control" value="{{ old('province', $agent->province) }}" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Alamat *</label>
                <textarea name="address" class="form-control" rows="3" required>{{ old('address', $agent->address) }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Deskripsi Agen *</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $agent->description) }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">💾 Update Profil</button>
        </form>
    </div>

    <!-- Ganti Password -->
    <div class="card">
        <div class="card-header">
            <h2>🔒 Ganti Password</h2>
        </div>
        
        <form action="{{ route('agen.profile.password') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Password Lama *</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Password Baru *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-warning">🔄 Ganti Password</button>
        </form>
    </div>

    <!-- Upload Logo -->
    <div class="card">
        <div class="card-header">
            <h2>📷 Logo Agen</h2>
        </div>
        
       <!-- Logo Preview -->
       <!-- Logo Preview -->
        <div style="text-align: center;">
            @if($agent->logo)
                <img src="{{ asset('storage/' . $agent->logo) }}" class="logo-preview" alt="Logo Agen" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #e8a83e; margin-bottom: 15px;">
            @else
                <div class="logo-preview" style="width: 100px; height: 100px; border-radius: 50%; background: #e8dfc8; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 15px auto;">🏢</div>
            @endif
            
           <form action="{{ route('agen.profile.upload-logo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="logo" accept="image/*" required>
                <button type="submit" class="btn btn-primary">Upload Logo</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>