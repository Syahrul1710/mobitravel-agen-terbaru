<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kendaraan - MobiTravel Agen</title>
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
        .logout-btn {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 12px 20px;
            color: #a8c5b0;
            cursor: pointer;
            margin-top: 30px;
        }
        .logout-btn:hover { background: #4e8060; color: white; }
        .main-content { margin-left: 260px; padding: 30px; }
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e8dfc8;
        }
        .card-header h2 { color: #1a3328; }
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border: none;
            display: inline-block;
        }
        .btn-primary { background: #1a3328; color: white; }
        .btn-warning { background: #e8a83e; color: #1a3328; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-info { background: #3b82f6; color: white; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e8dfc8; }
        th { background: #f5f0e8; font-weight: 600; }
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-available { background: #dcfce7; color: #16a34a; }
        .badge-booked { background: #fef3c7; color: #d97706; }
        .badge-maintenance { background: #fee2e2; color: #dc2626; }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>MobiTravel</h2>
    <ul class="sidebar-menu">
        <li><a href="{{ route('agen.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('agen.destinations.index') }}">Destinasi</a></li>
        <li><a href="{{ route('agen.tour-packages.index') }}">Paket Wisata</a></li>
        <li><a href="{{ route('agen.vehicles.index') }}" class="active">Kendaraan</a></li>
        <li><a href="{{ route('agen.bookings.index') }}">Pemesanan</a></li>
        <li><a href="{{ route('agen.profile.index') }}">Profil</a></li>
    </ul>
    <form method="POST" action="{{ route('agen.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>Daftar Kendaraan</h2>
            <a href="{{ route('agen.vehicles.create') }}" class="btn btn-primary">+ Tambah Kendaraan</a>
        </div>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Kendaraan</th>
                    <th>Plat Nomor</th>
                    <th>Kapasitas</th>
                    <th>Harga + Sopir</th>
                    <th>Harga Tanpa Sopir</th>
                    <th>Status</th>
                    <th>Rute</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $index => $vehicle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($vehicle->photo)
                            <img src="{{ asset('storage/' . $vehicle->photo) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        @else
                            🚘
                        @endif
                    </td>
                    <td>{{ $vehicle->name }}<br><small>{{ $vehicle->type }}</small></td>
                    <td>{{ $vehicle->plate_number }}</small></td>
                    <td>{{ $vehicle->capacity }} orang</small></td>
                    <td>Rp {{ number_format($vehicle->price_with_driver, 0, ',', '.') }}</small></td>
                    <td>Rp {{ number_format($vehicle->price_without_driver, 0, ',', '.') }}</small></td>
                    <td>
                        <span class="badge badge-{{ $vehicle->status }}">
                            {{ $vehicle->status == 'available' ? 'Tersedia' : ($vehicle->status == 'booked' ? 'Dipinjam' : 'Perbaikan') }}
                        </span>
                    </td>
                    <td>
                        @php 
                            $routes = is_string($vehicle->routes) ? json_decode($vehicle->routes, true) : ($vehicle->routes ?? []); 
                        @endphp
                        @if(count($routes) > 0)
                            <button class="btn btn-info btn-sm" onclick='showRoutes({{ json_encode($routes) }})'>Lihat Rute ({{ count($routes) }})</button>
                        @else
                            <span class="badge" style="background:#fef3c7; color:#d97706;">Belum ada rute</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('agen.vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('agen.vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" style="text-align:center;">Belum ada kendaraan. Tambah sekarang!</small></tr>
                @endforelse
            </tbody>
        </table>
        
        {{ $vehicles->links() }}
    </div>
</div>

<script>
    function showRoutes(routes) {
        let html = '<div style="max-height:400px; overflow-y:auto;"><table style="width:100%; border-collapse:collapse;">';
        html += '<thead><tr><th>Kota Asal</th><th>Kota Tujuan</th></tr></thead><tbody>';
        routes.forEach(route => {
            html += `<tr><td style="padding:8px;">${route.pickup}</td><td style="padding:8px;">${route.dropoff}</td></tr>`;
        });
        html += '</tbody></table></div>';
        
        const modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.background = 'rgba(0,0,0,0.5)';
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
        modal.style.zIndex = '9999';
        modal.innerHTML = `<div style="background:white; padding:20px; border-radius:12px; max-width:500px; width:90%;"><h3 style="margin-bottom:15px;">Daftar Rute</h3>${html}<button onclick="this.closest('div').parentElement.remove()" style="margin-top:15px; padding:8px 16px; background:#1a3328; color:white; border:none; border-radius:6px; cursor:pointer;">Tutup</button></div>`;
        document.body.appendChild(modal);
    }
</script>

</body>
</html>