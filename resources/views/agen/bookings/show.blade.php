<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan - MobiTravel Agen</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f0e8;
            color: #2e2e2e;
        }
        
        .sidebar {
            width: 260px;
            background: #1a3328;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px 0;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #e8a83e;
        }
        .sidebar-menu {
            list-style: none;
        }
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #a8c5b0;
            text-decoration: none;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #4e8060;
            color: white;
        }
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
        
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e8dfc8;
        }
        .info-label {
            width: 180px;
            font-weight: bold;
            color: #1a3328;
        }
        .info-value {
            flex: 1;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            border: none;
            cursor: pointer;
        }
        .btn-back { background: #666; color: white; }
        .btn-success { background: #16a34a; color: white; }
        .btn-warning { background: #e8a83e; color: #1a3328; }
        .badge-paid { background: #dcfce7; color: #16a34a; padding: 4px 12px; border-radius: 20px; }
        .badge-pending { background: #fef3c7; color: #d97706; padding: 4px 12px; border-radius: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>MobiTravel</h2>
        <ul class="sidebar-menu">
            <li><a href="{{ route('agen.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('agen.destinations.index') }}">Destinasi</a></li>
            <li><a href="{{ route('agen.tour-packages.index') }}">Paket Wisata</a></li>
            <li><a href="{{ route('agen.bookings.index') }}" class="active">Pemesanan</a></li>
            <li><a href="{{ route('agen.profile.index') }}">Profil</a></li>
        </ul>
        <form method="POST" action="{{ route('agen.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
    
    <div class="main-content">
        <a href="{{ route('agen.bookings.index') }}" class="btn btn-back">← Kembali</a>
        
        <div class="card">
            <h2>Detail Pemesanan</h2>
            <div class="info-row"><div class="info-label">Kode Booking</div><div class="info-value">{{ $booking->booking_code }}</div></div>
            <div class="info-row"><div class="info-label">Nama Pemesan</div><div class="info-value">{{ $booking->customer_name }}</div></div>
            <div class="info-row"><div class="info-label">Email</div><div class="info-value">{{ $booking->customer_email }}</div></div>
            <div class="info-row"><div class="info-label">WhatsApp</div><div class="info-value">{{ $booking->customer_phone }}</div></div>
            <div class="info-row"><div class="info-label">Paket Wisata</div><div class="info-value">{{ $booking->tourPackage->name ?? '-' }}</div></div>
            <div class="info-row"><div class="info-label">Destinasi</div><div class="info-value">{{ $booking->tourPackage->destination->name ?? '-' }}</div></div>
            <div class="info-row"><div class="info-label">Tanggal Perjalanan</div><div class="info-value">{{ $booking->travel_date ?? '-' }}</div></div>
            <div class="info-row"><div class="info-label">Jumlah Peserta</div><div class="info-value">{{ $booking->participants }} orang</div></div>
            <div class="info-row"><div class="info-label">Total Harga</div><div class="info-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div></div>
            <div class="info-row"><div class="info-label">Status Pembayaran</div>
                <div class="info-value">
                    <span class="badge-{{ $booking->payment_status == 'paid' ? 'paid' : 'pending' }}">
                        {{ $booking->payment_status == 'paid' ? 'Lunas' : 'Menunggu Pembayaran' }}
                    </span>
                </div>
            </div>
            <div class="info-row"><div class="info-label">Tanggal Booking</div><div class="info-value">{{ $booking->created_at->format('d/m/Y H:i') }}</div></div>
            @if($booking->special_requests)
            <div class="info-row"><div class="info-label">Catatan</div><div class="info-value">{{ $booking->special_requests }}</div></div>
            @endif
        </div>
        
        <div class="card">
            <h2>Update Status</h2>
            <form action="{{ route('agen.bookings.update-payment', $booking->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('PUT')
                <input type="hidden" name="payment_status" value="paid">
                <button type="submit" class="btn btn-success">Mark as Paid</button>
            </form>
            <form action="{{ route('agen.bookings.cancel', $booking->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-warning" onclick="return confirm('Batalkan pesanan ini?')">Batalkan Pesanan</button>
            </form>
        </div>
    </div>
</body>
</html>