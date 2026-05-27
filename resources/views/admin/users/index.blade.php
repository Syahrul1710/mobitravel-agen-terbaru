@extends('admin.layouts.app')

@section('title', 'Manajemen User')
@section('menu-users', 'active')

@section('content')
<div class="main-content">
    <div class="stats">
        <div class="stat-card"><h3>{{ $totalUsers }}</h3><p>Total User</p></div>
        <div class="stat-card"><h3>{{ $activeUsers }}</h3><p>User Aktif</p></div>
        <div class="stat-card"><h3>{{ $blockedUsers }}</h3><p>User Diblokir</p></div>
    </div>
    
    <div class="card">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <h2>Daftar User</h2>
            <form method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="Cari nama/email..." class="search-box" value="{{ request('search') }}">
                <button type="submit" class="btn btn-info">Cari</button>
            </form>
        </div>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="badge-active">Aktif</span>
                        @else
                            <span class="badge-blocked">Diblokir</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">Detail</a>
                        @if($user->is_active)
                            <form action="{{ route('admin.users.block', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Blokir user ini?')">Blokir</button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success" onclick="return confirm('Aktifkan user ini?')">Aktifkan</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus user ini secara permanen? Semua data booking juga akan terhapus.')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;">Belum ada user yang terdaftar</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>

<style>
    .main-content {
        margin-left: 0;
        padding: 30px;
    }
    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
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
    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        border: none;
        cursor: pointer;
    }
    .btn-danger { background: #dc2626; color: white; }
    .btn-warning { background: #e8a83e; color: #1a3328; }
    .btn-success { background: #16a34a; color: white; }
    .btn-info { background: #3b82f6; color: white; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e8dfc8; }
    th { background: #f5f0e8; }
    .badge-active { background: #dcfce7; color: #16a34a; padding: 4px 8px; border-radius: 20px; font-size: 12px; }
    .badge-blocked { background: #fee2e2; color: #dc2626; padding: 4px 8px; border-radius: 20px; font-size: 12px; }
    .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
    .search-box { padding: 8px; border: 1px solid #e8dfc8; border-radius: 6px; width: 250px; }
</style>
@endsection