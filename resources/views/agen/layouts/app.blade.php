<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MobiTravel Agen</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f0e8; }
        .sidebar {
            width: 260px;
            background: #1a3328;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: #a8c5b0;
            padding: 12px 0;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active { color: #e8a83e; }
        .content {
            margin-left: 260px;
            padding: 80px 40px 40px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e8dfc8;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #1a3328; color: white; }
        .btn-warning { background: #e8a83e; color: #1a3328; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e8dfc8;
            border-radius: 6px;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e8dfc8; }
        th { background: #f5f0e8; }
        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .error { color: #dc2626; font-size: 12px; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .content { margin-left: 0; }
            .row { grid-template-columns: 1fr; }
        }

        .alert {
         padding: 12px;
         border-radius: 8px;
          margin-bottom: 20px;
         }
        .alert-danger {
         background: #fee2e2;
          color: #dc2626;
          border: 1px solid #fecaca;
        }
        .alert-success {
         background: #dcfce7;
         color: #16a34a;
         border: 1px solid #bbf7d0;
     }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>MobiTravel</h2>
        <hr style="margin: 15px 0; border-color: #2d5a3d;">
        <a href="{{ route('agen.dashboard') }}" class="@yield('menu-dashboard')">Dashboard</a>
        <a href="{{ route('agen.destinations.index') }}" class="@yield('menu-destinasi')">Destinasi</a>
        <a href="#">Paket Wisata</a>
        <a href="#">Pemesanan</a>
        <a href="#">Profil</a>
        <hr style="margin: 15px 0; border-color: #2d5a3d;">
        <form method="POST" action="{{ route('agen.logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; color:#a8c5b0; cursor:pointer;">Logout</button>
        </form>
    </div>
    
    <div class="content">
        @yield('content')
    </div>
</body>
</html>