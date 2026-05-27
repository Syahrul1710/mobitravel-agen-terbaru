@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('menu-dashboard', 'active')

@section('content')
<div class="content">
    <div class="header">
        <h1>Dashboard</h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
    
    <div class="stats">
        <div class="stat-card">
            <h3>Total Agen</h3>
            <div class="number">{{ $totalAgents }}</div>
        </div>
        <div class="stat-card">
            <h3>Menunggu Verifikasi</h3>
            <div class="number">{{ $pendingAgents }}</div>
        </div>
        <div class="stat-card">
            <h3>Agen Aktif</h3>
            <div class="number">{{ $activeAgents }}</div>
        </div>
        <div class="stat-card">
            <h3>Total Booking</h3>
            <div class="number">{{ $totalBookings }}</div>
        </div>
        <div class="stat-card">
            <h3>Total Paket</h3>
            <div class="number">{{ $totalPackages }}</div>
        </div>
    </div>
</div>

<style>
    .content {
        margin-left: 0;
        padding: 20px 40px;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .stat-card h3 { font-size: 14px; color: #666; margin-bottom: 10px; }
    .stat-card .number { font-size: 32px; font-weight: bold; color: #1a3328; }
    .logout-btn {
        background: #dc2626;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
    }
    .logout-btn:hover { background: #b91c1c; }
</style>
@endsection