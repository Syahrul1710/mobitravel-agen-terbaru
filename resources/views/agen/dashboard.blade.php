<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Agen - MobiTravel</title>
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
            margin-bottom: 20px;
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
        
        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            font-size: 2rem;
            color: #1a3328;
            margin-bottom: 5px;
        }
        .stat-card p {
            color: #7a7a6e;
            font-size: 0.9rem;
        }
        
        /* PROFILE CARD */
        .profile-card {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
        }
        .profile-avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-avatar .avatar-placeholder {
            width: 80px;
            height: 80px;
            background: #e8a83e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }
        .profile-info h3 {
            font-size: 1.5rem;
            color: #1a3328;
        }
        .profile-info p {
            color: #7a7a6e;
            margin: 5px 0;
        }
        
        /* RULES LIST */
        .rules-list {
            list-style: none;
            padding-left: 0;
        }
        .rules-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e8dfc8;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .rules-list li:before {
            content: "✓";
            color: #16a34a;
            font-weight: bold;
        }
        
        /* BUTTONS */
        .btn {
            display: inline-block;
            padding: 8px 16px;
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
        
        /* BADGE */
        .badge-active {
            color: #16a34a;
        }
        .badge-pending {
            color: #d97706;
        }
        .badge-suspended {
            color: #dc2626;
        }
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .profile-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>MobiTravel</h2>
    <ul class="sidebar-menu">
        <li><a href="{{ route('agen.dashboard') }}" class="active">📊 Dashboard</a></li>
        <li><a href="{{ route('agen.destinations.index') }}">📍 Destinasi</a></li>
        <li><a href="{{ route('agen.tour-packages.index') }}">✈️ Paket Wisata</a></li>
        <li><a href="{{ route('agen.vehicles.index') }}">🚗 Kendaraan</a></li>
        <li><a href="{{ route('agen.bookings.index') }}">📋 Pemesanan</a></li>
        <li><a href="{{ route('agen.profile.index') }}">👤 Profil</a></li>
    </ul>
    <form method="POST" action="{{ route('agen.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">🚪 Logout</button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    
    <!-- Profile Card -->
    <div class="card">
        <div class="profile-card">
            <div class="profile-avatar">
                @if($agent->logo && Storage::disk('public')->exists($agent->logo))
                    <img src="{{ asset('storage/' . $agent->logo) }}" alt="Logo">
                @else
                    <div class="avatar-placeholder">
                        {{ substr($agent->agency_name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="profile-info">
                <h3>👋 Selamat Datang, {{ $agent->agency_name }}!</h3>
                <p>{{ $agent->email }} | {{ $agent->phone }} | {{ $agent->city }}</p>
                <p>Status: 
                    @if($agent->status == 'active')
                        <span class="badge-active">✅ Aktif</span>
                    @elseif($agent->status == 'pending')
                        <span class="badge-pending">⏳ Menunggu Verifikasi</span>
                    @else
                        <span class="badge-suspended">❌ Ditangguhkan</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $totalDestinasi ?? 0 }}</h3>
            <p>Total Destinasi</p>
        </div>
        <div class="stat-card">
            <h3>{{ $totalPackages ?? 0 }}</h3>
            <p>Total Paket Wisata</p>
        </div>
        <div class="stat-card">
            <h3>{{ $totalVehicles ?? 0 }}</h3>
            <p>Total Kendaraan</p>
        </div>
        <div class="stat-card">
            <h3>{{ $totalRoutes ?? 0 }}</h3>
            <p>Total Rute</p>
        </div>
        <div class="stat-card">
            <h3>{{ $totalBookings ?? 0 }}</h3>
            <p>Total Pemesanan</p>
        </div>
        <div class="stat-card">
            <h3>{{ $pendingPayments ?? 0 }}</h3>
            <p>Menunggu Bayar</p>
        </div>
        <div class="stat-card">
            <h3>Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            <p>Total Pendapatan</p>
        </div>
        <div class="stat-card">
            <h3>⭐ {{ number_format($averageRating ?? 0, 1) }}</h3>
            <p>Rating Rata-rata</p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h2>⚡ Aksi Cepat</h2>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            <a href="{{ route('agen.destinations.create') }}" class="btn btn-primary">📍 Tambah Destinasi</a>
            <a href="{{ route('agen.tour-packages.create') }}" class="btn btn-primary">✈️ Tambah Paket Wisata</a>
            <a href="{{ route('agen.vehicles.create') }}" class="btn btn-primary">🚗 Tambah Kendaraan</a>
            <a href="{{ route('agen.bookings.index') }}" class="btn btn-primary">📋 Lihat Pemesanan</a>
        </div>
    </div>
    
    <!-- Peraturan & Ketentuan -->
    <div class="card">
        <div class="card-header">
            <h2>📜 Peraturan & Ketentuan Agen</h2>
        </div>
        <ul class="rules-list">
            @foreach($rules as $rule)
                <li>{{ $rule }}</li>
            @endforeach
        </ul>
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e8dfc8; font-size: 12px; color: #7a7a6e;">
            <p>⚠️ Pelanggaran terhadap ketentuan di atas dapat mengakibatkan suspend atau penutupan akun secara permanen.</p>
            <p>📞 Untuk pertanyaan lebih lanjut, hubungi admin melalui email: admin@mobitravel.com</p>
        </div>
    </div>
    
</div>

</body>
</html>