<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rute Paket - MobiTravel Agen</title>
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
        
        /* FORM */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1a3328;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #e8dfc8;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-control:focus {
            outline: none;
            border-color: #4e8060;
        }
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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
        .btn-secondary {
            background: #666;
            color: white;
        }
        .btn-secondary:hover {
            background: #555;
        }
        
        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>MobiTravel</h2>
    <ul class="sidebar-menu">
        <li><a href="{{ route('agen.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('agen.destinations.index') }}">Destinasi</a></li>
        <li><a href="{{ route('agen.tour-packages.index') }}">Paket Wisata</a></li>
        <li><a href="{{ route('agen.vehicles.index') }}">Kendaraan</a></li>
        <li><a href="{{ route('agen.route-packages.index') }}" class="active">Rute Paket</a></li>
        <li><a href="{{ route('agen.travel-requests.index') }}">Permintaan Travel</a></li>
        <li><a href="{{ route('agen.bookings.index') }}">Pemesanan</a></li>
        <li><a href="{{ route('agen.profile.index') }}">Profil</a></li>
    </ul>
    <form method="POST" action="{{ route('agen.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>Edit Rute Paket</h2>
        </div>
        
        <form action="{{ route('agen.route-packages.update', $route->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="form-group">
                    <label>Kota Asal *</label>
                    <input type="text" name="pickup_city" class="form-control" value="{{ old('pickup_city', $route->pickup_city) }}" required>
                    @error('pickup_city') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Kota Tujuan *</label>
                    <input type="text" name="dropoff_city" class="form-control" value="{{ old('dropoff_city', $route->dropoff_city) }}" required>
                    @error('dropoff_city') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Harga Sewa + Sopir *</label>
                    <input type="number" name="price_with_driver" class="form-control" value="{{ old('price_with_driver', $route->price_with_driver) }}" required>
                    @error('price_with_driver') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Harga Sewa Tanpa Sopir *</label>
                    <input type="number" name="price_without_driver" class="form-control" value="{{ old('price_without_driver', $route->price_without_driver) }}" required>
                    @error('price_without_driver') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Estimasi Waktu (jam)</label>
                    <input type="number" name="estimated_hours" class="form-control" value="{{ old('estimated_hours', $route->estimated_hours) }}">
                </div>
                <div class="form-group">
                    <label>Jarak (km)</label>
                    <input type="number" name="distance_km" class="form-control" value="{{ old('distance_km', $route->distance_km) }}">
                </div>
            </div>
            
            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">💾 Update Rute</button>
                <a href="{{ route('agen.route-packages.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>