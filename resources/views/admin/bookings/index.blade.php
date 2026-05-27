@extends('admin.layouts.app')

@section('title', 'Manajemen Pemesanan')
@section('menu-bookings', 'active')

@section('content')
<div class="main-content">
    <div class="stats">
        <div class="stat-card"><h3>{{ $totalBookings }}</h3><p>Total Booking</p></div>
        <div class="stat-card"><h3>{{ $pendingPayments }}</h3><p>Menunggu Bayar</p></div>
        <div class="stat-card"><h3>{{ $paidBookings }}</h3><p>Selesai</p></div>
        <div class="stat-card"><h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3><p>Pendapatan</p></div>
    </div>
    
    <div class="card">
        <h2>Daftar Pemesanan</h2>
        
        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="Cari kode/nama..." value="{{ request('search') }}">
            <select name="payment_status">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="Dari tgl">
            <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="Sampai tgl">
            <button type="submit" class="btn btn-info">Filter</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-info">Reset</a>
        </form>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pemesan</th>
                    <th>Paket</th>
                    <th>Agen</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->tourPackage->name ?? '-' }}</td>
                    <td>{{ $booking->agent->agency_name ?? '-' }}</td>
                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge-{{ $booking->payment_status == 'paid' ? 'paid' : 'pending' }}">
                            {{ $booking->payment_status == 'paid' ? 'Lunas' : 'Menunggu' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-info">Detail</a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus booking ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;">Belum ada pemesanan</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $bookings->links() }}
    </div>
</div>

<style>
    .main-content {
        margin-left: 0;
        padding: 30px;
    }
    .stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
    .stat-card h3 { font-size: 2rem; color: #1a3328; }
    .card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; text-align: left; border-bottom: 1px solid #e8dfc8; }
    th { background: #f5f0e8; }
    .btn { padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px; display: inline-block; }
    .btn-info { background: #3b82f6; color: white; }
    .btn-danger { background: #dc2626; color: white; }
    .badge-paid { background: #dcfce7; color: #16a34a; padding: 4px 8px; border-radius: 20px; font-size: 11px; }
    .badge-pending { background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 20px; font-size: 11px; }
    .filter-form { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .filter-form select, .filter-form input { padding: 8px; border: 1px solid #e8dfc8; border-radius: 6px; }
    .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
</style>
@endsection