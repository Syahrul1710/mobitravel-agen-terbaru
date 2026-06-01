<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kendaraan - MobiTravel Agen</title>
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
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e8dfc8;
        }
        .card-header h2 { color: #1a3328; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #1a3328; }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #e8dfc8;
            border-radius: 6px;
        }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-primary { background: #1a3328; color: white; }
        .btn-secondary { background: #666; color: white; }
        .error { color: #dc2626; font-size: 12px; margin-top: 5px; }
        .photo-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>MobiTravel</h2>
        <ul class="sidebar-menu">
            <li><a href="{{ route('agen.dashboard') }}">📊 Dashboard</a></li>
            <li><a href="{{ route('agen.destinations.index') }}">📍 Destinasi</a></li>
            <li><a href="{{ route('agen.tour-packages.index') }}">✈️ Paket Wisata</a></li>
            <li><a href="{{ route('agen.vehicles.index') }}" class="active">🚗 Kendaraan</a></li>
            <li><a href="{{ route('agen.bookings.index') }}">📋 Pemesanan</a></li>
            <li><a href="{{ route('agen.profile.index') }}">👤 Profil</a></li>
        </ul>
        <form method="POST" action="{{ route('agen.logout') }}">@csrf<button type="submit" class="logout-btn">🚪 Logout</button></form>
    </div>
    
    <div class="main-content">
        <div class="card">
            <div class="card-header"><h2>✏️ Edit Kendaraan</h2></div>
            <form action="{{ route('agen.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="form-group">
                        <label>Nama Kendaraan *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $vehicle->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe *</label>
                        <select name="type" class="form-control" required>
                            <option value="MPV" {{ $vehicle->type == 'MPV' ? 'selected' : '' }}>MPV</option>
                            <option value="SUV" {{ $vehicle->type == 'SUV' ? 'selected' : '' }}>SUV</option>
                            <option value="Minibus" {{ $vehicle->type == 'Minibus' ? 'selected' : '' }}>Minibus</option>
                            <option value="Bus" {{ $vehicle->type == 'Bus' ? 'selected' : '' }}>Bus</option>
                            <option value="Hatchback" {{ $vehicle->type == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <label>Plat Nomor *</label>
                        <input type="text" name="plate_number" class="form-control" value="{{ old('plate_number', $vehicle->plate_number) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kapasitas Penumpang *</label>
                        <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $vehicle->capacity) }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Fasilitas</label>
                    <textarea name="facilities" class="form-control" rows="2" placeholder="AC, Music, USB Charger, dll">{{ old('facilities', $vehicle->facilities) }}</textarea>
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <label>Harga Sewa + Sopir *</label>
                        <input type="number" name="price_with_driver" class="form-control" value="{{ old('price_with_driver', $vehicle->price_with_driver) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Sewa Tanpa Sopir *</label>
                        <input type="number" name="price_without_driver" class="form-control" value="{{ old('price_without_driver', $vehicle->price_without_driver) }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="available" {{ $vehicle->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="booked" {{ $vehicle->status == 'booked' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Foto Kendaraan</label>
                    @if($vehicle->photo)
                        <div><img src="{{ asset('storage/' . $vehicle->photo) }}" class="photo-preview"></div>
                    @endif
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small>Kosongkan jika tidak ingin mengubah foto</small>
                </div>
                
                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="{{ route('agen.vehicles.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>