<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rute Paket - MobiTravel Agen</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f0e8; }
        .sidebar {
            width: 260px;
            background: #1a3328;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px 0;
        }
        .sidebar h2 { text-align: center; margin-bottom: 30px; color: #e8a83e; }
        .sidebar-menu { list-style: none; }
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #a8c5b0;
            text-decoration: none;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #4e8060; color: white; }
        .main-content { margin-left: 260px; padding: 30px; }
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-header { display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e8dfc8; }
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        .btn-primary { background: #1a3328; color: white; }
        .btn-warning { background: #e8a83e; color: #1a3328; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e8dfc8; }
        th { background: #f5f0e8; }
        .badge-active { background: #dcfce7; color: #16a34a; padding: 4px 8px; border-radius: 20px; font-size: 11px; }
        .badge-inactive { background: #fee2e2; color: #dc2626; padding: 4px 8px; border-radius: 20px; font-size: 11px; }
        .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>MobiTravel</h2>
        <ul class="sidebar-menu">
            <li><a href="{{ route('agen.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('agen.destinations.index') }}">Destinasi</a></li>
            <li><a href="{{ route('agen.tour-packages.index') }}">Paket Wisata</a></li>
            <li><a href="{{ route('agen.vehicles.index') }}">Kendaraan</a></li>
            <li><a href="{{ route('agen.bookings.index') }}">Booking</a></li>
            <li><a href="{{ route('agen.profile.index') }}">Profil</a></li>
        </ul>
        <form method="POST" action="{{ route('agen.logout') }}">@csrf<button type="submit" class="btn btn-danger" style="margin-left: 20px;">Logout</button></form>
    </div>
    
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h2>🗺️ Daftar Rute Paket</h2>
                <a href="{{ route('agen.route-packages.create') }}" class="btn btn-primary">+ Tambah Rute</a>
            </div>
            
            @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
            
            <table>
                <thead><tr><th>No</th><th>Rute</th><th>Harga + Sopir</th><th>Harga Tanpa Sopir</th><th>Durasi</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($routes as $index => $route)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td><strong>{{ $route->pickup_city }}</strong> → <strong>{{ $route->dropoff_city }}</strong></td>
                        <td>Rp {{ number_format($route->price_with_driver, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($route->price_without_driver, 0, ',', '.') }}</td>
                        <td>{{ $route->estimated_hours ? $route->estimated_hours . ' jam' : '-' }}</td>
                        <td><span class="badge-{{ $route->is_active ? 'active' : 'inactive' }}">{{ $route->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <a href="{{ route('agen.route-packages.edit', $route->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('agen.route-packages.toggle-status', $route->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary btn-sm">{{ $route->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                            </form>
                            <form action="{{ route('agen.route-packages.destroy', $route->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus rute ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;">Belum ada rute. Tambah sekarang!</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $routes->links() }}
        </div>
    </div>
</body>
</html>