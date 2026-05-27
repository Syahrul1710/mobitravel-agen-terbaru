@extends('admin.layouts.app')

@section('title', 'Detail User')
@section('menu-users', 'active')

@section('content')
<div class="main-content">
    <a href="{{ route('admin.users.index') }}" class="btn btn-back">← Kembali</a>
    
    <div class="card">
        <h2>Detail User</h2>
        <div class="info-row">
            <div class="info-label">ID User</div>
            <div class="info-value">{{ $user->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nama Lengkap</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $user->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Daftar</div>
            <div class="info-value">{{ $user->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">
                @if($user->is_active)
                    <span class="badge-paid">Aktif</span>
                @else
                    <span class="badge-pending">Diblokir</span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="card">
        <h2>Riwayat Pemesanan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Booking</th>
                    <th>Paket Wisata</th>
                    <th>Agen</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user->bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->tourPackage->name ?? '-' }}</td>
                    <td>{{ $booking->agent->agency_name ?? '-' }}</td>
                    <td>{{ $booking->travel_date ?? $booking->created_at->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $booking->payment_status == 'paid' ? 'badge-paid' : 'badge-pending' }}">
                            {{ $booking->payment_status }}
                        </span>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;">Belum ada pemesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .main-content {
        margin-left: 0;
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
    .info-label { width: 180px; font-weight: bold; color: #1a3328; }
    .info-value { flex: 1; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; text-align: left; border-bottom: 1px solid #e8dfc8; }
    th { background: #f5f0e8; }
    .badge { padding: 4px 8px; border-radius: 20px; font-size: 12px; }
    .badge-paid { background: #dcfce7; color: #16a34a; }
    .badge-pending { background: #fef3c7; color: #d97706; }
    .btn { padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; display: inline-block; }
    .btn-back { background: #666; color: white; }
</style>
@endsection