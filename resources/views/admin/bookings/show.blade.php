@extends('admin.layouts.app')

@section('title', 'Detail Booking')
@section('menu-bookings', 'active')

@section('content')
<div class="main-content">
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-back">← Kembali</a>
    
    <div class="card">
        <h2>Detail Pemesanan</h2>
        <div class="info-row"><div class="info-label">Kode Booking</div><div class="info-value">{{ $booking->booking_code }}</div></div>
        <div class="info-row"><div class="info-label">Nama Pemesan</div><div class="info-value">{{ $booking->customer_name }}</div></div>
        <div class="info-row"><div class="info-label">Email</div><div class="info-value">{{ $booking->customer_email }}</div></div>
        <div class="info-row"><div class="info-label">WhatsApp</div><div class="info-value">{{ $booking->customer_phone }}</div></div>
        <div class="info-row"><div class="info-label">Paket Wisata</div><div class="info-value">{{ $booking->tourPackage->name ?? '-' }}</div></div>
        <div class="info-row"><div class="info-label">Agen</div><div class="info-value">{{ $booking->agent->agency_name ?? '-' }}</div></div>
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
        <form action="{{ route('admin.bookings.update-payment', $booking->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('PUT')
            <input type="hidden" name="payment_status" value="paid">
            <button type="submit" class="btn btn-success">Mark as Paid</button>
        </form>
        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-warning" onclick="return confirm('Batalkan pesanan ini?')">Batalkan Pesanan</button>
        </form>
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
    .btn { padding: 8px 16px; border-radius: 6px; text-decoration: none; display: inline-block; margin-right: 10px; }
    .btn-back { background: #666; color: white; }
    .btn-success { background: #16a34a; color: white; border: none; cursor: pointer; }
    .btn-warning { background: #e8a83e; color: #1a3328; border: none; cursor: pointer; }
    .badge-paid { background: #dcfce7; color: #16a34a; padding: 4px 12px; border-radius: 20px; }
    .badge-pending { background: #fef3c7; color: #d97706; padding: 4px 12px; border-radius: 20px; }
</style>
@endsection