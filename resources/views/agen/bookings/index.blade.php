<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - MobiTravel Agen</title>
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
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card-header { display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e8dfc8; }
        .card-header h2 { color: #1a3328; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .stat-card h3 { font-size: 2rem; color: #1a3328; }
        .btn { padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; border: none; cursor: pointer; display: inline-block; }
        .btn-info { background: #3b82f6; color: white; }
        .btn-warning { background: #e8a83e; color: #1a3328; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-success { background: #16a34a; color: white; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e8dfc8; }
        th { background: #f5f0e8; font-weight: 600; }
        .badge-paid { background: #dcfce7; color: #16a34a; padding: 4px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-pending { background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-expired { background: #fee2e2; color: #dc2626; padding: 4px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .filter-form { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .filter-form input, .filter-form select { padding: 8px; border: 1px solid #e8dfc8; border-radius: 6px; }
        .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .stats { grid-template-columns: repeat(2, 1fr); }
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
            <li><a href="{{ route('agen.vehicles.index') }}">Kendaraan</a></li>
            <li><a href="{{ route('agen.bookings.index') }}" class="active">Pemesanan</a></li>
            <li><a href="{{ route('agen.profile.index') }}">Profil</a></li>
        </ul>
        <form method="POST" action="{{ route('agen.logout') }}">@csrf<button type="submit" class="logout-btn">Logout</button></form>
    </div>
    
    <div class="main-content">
        <div class="stats">
            <div class="stat-card"><h3>{{ $totalBookings ?? 0 }}</h3><p>Total Pesanan</p></div>
            <div class="stat-card"><h3>{{ $pendingPayments ?? 0 }}</h3><p>Menunggu Pembayaran</p></div>
            <div class="stat-card"><h3>{{ $paidBookings ?? 0 }}</h3><p>Selesai / Lunas</p></div>
            <div class="stat-card"><h3>Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3><p>Total Pendapatan</p></div>
        </div>
        
        <div class="card">
            <div class="card-header"><h2>Daftar Pemesanan</h2></div>
            
            <form method="GET" class="filter-form">
                <input type="text" name="search" placeholder="Cari kode/nama/email..." value="{{ request('search') }}">
                <select name="type">
                    <option value="">Semua Jenis</option>
                    <option value="package" {{ request('type') == 'package' ? 'selected' : '' }}>Paket Wisata</option>
                    <option value="vehicle" {{ request('type') == 'vehicle' ? 'selected' : '' }}>Kendaraan</option>
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Bayar</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                </select>
                <button type="submit" class="btn btn-info">Filter</button>
                <a href="{{ route('agen.bookings.index') }}" class="btn btn-warning">Reset</a>
            </form>
            
            @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pemesan</th>
                        <th>Jenis</th>
                        <th>Item / Rute</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->booking_code }}</td>
                        <td>
                            <strong>{{ $booking->customer_name }}</strong><br>
                            <small>{{ $booking->customer_email }}</small>
                        </td>
                        <td>
                            @if($booking->booking_type == 'package')
                                Paket Wisata
                            @else
                                Kendaraan
                            @endif
                        </td>
                        <td>
                            @if($booking->booking_type == 'package')
                                <strong>{{ $booking->tourPackage->name ?? '-' }}</strong><br>
                                <small>{{ $booking->tourPackage->destination->name ?? '-' }}</small>
                            @else
                                <strong>{{ $booking->vehicle->name ?? '-' }}</strong><br>
                                <small>{{ $booking->pickup_location }} → {{ $booking->dropoff_location }}</small><br>
                                <small>Sopir: {{ $booking->with_driver ? 'Ya' : 'Tidak' }}</small>
                            @endif
                        </td>
                        <td>{{ $booking->created_at->format('d/m/Y') }}<br><small>{{ $booking->travel_date ?? '-' }}</small></td>
                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($booking->payment_status == 'paid')
                                <span class="badge-paid">Lunas</span>
                            @elseif($booking->payment_status == 'pending')
                                <span class="badge-pending">Menunggu</span>
                            @else
                                <span class="badge-expired">Kadaluarsa</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('agen.bookings.show', $booking->id) }}" class="btn btn-info btn-sm">Detail</a>
                            @if($booking->payment_status == 'pending')
                                <form action="{{ route('agen.bookings.update-payment', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="payment_status" value="paid">
                                    <button type="submit" class="btn btn-success btn-sm">Mark Paid</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="8" style="text-align:center;">📭 Belum ada pemesanan</small></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $bookings->links() }}
        </div>
    </div>
</body>
</html>