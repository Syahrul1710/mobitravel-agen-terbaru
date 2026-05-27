<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket Wisata - MobiTravel Agen</title>
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
        .btn-warning {
            background: #e8a83e;
            color: #1a3328;
        }
        .btn-warning:hover {
            background: #c17f3b;
        }
        .btn-danger {
            background: #dc2626;
            color: white;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
        .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }
        
        /* TABLE */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e8dfc8;
        }
        .table th {
            background: #f5f0e8;
            font-weight: 600;
        }
        
        /* BADGE */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-success {
            background: #dcfce7;
            color: #16a34a;
        }
        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        
        /* ALERT */
        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        /* PAGINATION */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #e8dfc8;
            border-radius: 6px;
            text-decoration: none;
            color: #1a3328;
        }
        .pagination .active {
            background: #1a3328;
            color: white;
            border-color: #1a3328;
        }
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .table { font-size: 12px; }
            .table th, .table td { padding: 8px; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<!-- SIDEBAR -->
<div class="sidebar">
    <h2>MobiTravel</h2>
    <ul class="sidebar-menu">
        <li><a href="{{ route('agen.dashboard') }}" class="@yield('menu-dashboard', '')">📊 Dashboard</a></li>
        <li><a href="{{ route('agen.destinations.index') }}" class="@yield('menu-destinasi', '')">📍 Destinasi</a></li>
        <li><a href="{{ route('agen.tour-packages.index') }}" class="@yield('menu-paket', '')">✈️ Paket Wisata</a></li>
        <li><a href="{{ route('agen.vehicles.index') }}" class="@yield('menu-kendaraan', '')">🚗 Kendaraan</a></li>
        <li><a href="{{ route('agen.bookings.index') }}" class="@yield('menu-pemesanan', '')">📋 Pemesanan</a></li>
        <li><a href="{{ route('agen.profile.index') }}" class="@yield('menu-profil', '')">👤 Profil</a></li>
    </ul>
    <form method="POST" action="{{ route('agen.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">🚪 Logout</button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>✈️ Paket Wisata</h2>
            <div>
                <a href="{{ route('agen.destinations.index') }}" class="btn btn-primary" style="margin-right: 10px; background: #4e8060;">📍 Kelola Destinasi</a>
                <a href="{{ route('agen.tour-packages.create') }}" class="btn btn-primary">+ Tambah Paket</a>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Paket</th>
                    <th>Destinasi</th>
                    <th>Durasi</th>
                    <th>Harga</th>
                    <th>Kuota</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $index => $pkg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pkg->name }}</td>
                    <td>{{ $pkg->destination->name ?? '-' }} </td>
                    <td>{{ $pkg->duration }} </td>
                    <td>Rp {{ number_format($pkg->price, 0, ',', '.') }} </td>
                    <td>{{ $pkg->quota }} orang </td>
                    <td>
                        <span class="badge {{ $pkg->status == 'available' ? 'badge-success' : 'badge-danger' }}">
                            {{ $pkg->status == 'available' ? 'Tersedia' : 'Habis' }}
                        </span>
                     </td>
                    <td>
                        <a href="{{ route('agen.tour-packages.edit', $pkg->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('agen.tour-packages.destroy', $pkg->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus paket ini?')">Hapus</button>
                        </form>
                     </td>
                 </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;">❌ Belum ada paket wisata. <a href="{{ route('agen.tour-packages.create') }}">Tambah sekarang!</a></td>
                 </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if(method_exists($packages, 'links'))
            <div class="pagination">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</div>

</body>
</html>