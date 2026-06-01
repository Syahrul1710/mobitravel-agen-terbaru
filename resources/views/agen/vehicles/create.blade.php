<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan - MobiTravel Agen</title>
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
        .btn-danger { background: #dc2626; color: white; }
        .error { color: #dc2626; font-size: 12px; margin-top: 5px; }
        .route-item {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        .route-item .form-control {
            flex: 1;
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .row { grid-template-columns: 1fr; }
            .route-item { flex-direction: column; }
            .route-item .form-control { width: 100%; }
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
            <div class="card-header"><h2>➕ Tambah Kendaraan</h2></div>
            <form action="{{ route('agen.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group"><label>Nama Kendaraan *</label><input type="text" name="name" class="form-control" required></div>
                    <div class="form-group"><label>Tipe *</label><select name="type" class="form-control" required><option value="MPV">MPV</option><option value="SUV">SUV</option><option value="Minibus">Minibus</option><option value="Bus">Bus</option><option value="Hatchback">Hatchback</option></select></div>
                </div>
                <div class="row">
                    <div class="form-group"><label>Plat Nomor *</label><input type="text" name="plate_number" class="form-control" required></div>
                    <div class="form-group"><label>Kapasitas Penumpang *</label><input type="number" name="capacity" class="form-control" required></div>
                </div>
                <div class="form-group"><label>Fasilitas</label><textarea name="facilities" class="form-control" rows="2" placeholder="AC, Music, USB Charger, dll"></textarea></div>
                <div class="row">
                    <div class="form-group"><label>Harga Sewa + Sopir *</label><input type="number" name="price_with_driver" class="form-control" required></div>
                    <div class="form-group"><label>Harga Sewa Tanpa Sopir *</label><input type="number" name="price_without_driver" class="form-control" required></div>
                </div>
                
                <div class="form-group"><label>Foto Kendaraan</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
                
                <!-- Bagian Rute Perjalanan (tanpa harga) -->
                <div class="form-group">
                    <label>🗺️ Rute Perjalanan (opsional)</label>
                    <div id="routes-container">
                        <div class="route-item">
                            <input type="text" name="routes[0][pickup]" placeholder="Kota Asal" class="form-control">
                            <input type="text" name="routes[0][dropoff]" placeholder="Kota Tujuan" class="form-control">
                            <button type="button" class="btn btn-danger remove-route">✖</button>
                        </div>
                    </div>
                    <button type="button" id="add-route" class="btn btn-primary" style="background:#4e8060; margin-top:10px;">+ Tambah Rute</button>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('agen.vehicles.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
    
    <script>
        let routeIndex = 1;
        const addRouteBtn = document.getElementById('add-route');
        if (addRouteBtn) {
            addRouteBtn.addEventListener('click', function() {
                const container = document.getElementById('routes-container');
                const newRoute = document.createElement('div');
                newRoute.className = 'route-item';
                newRoute.style.display = 'flex';
                newRoute.style.gap = '10px';
                newRoute.style.marginBottom = '10px';
                newRoute.innerHTML = `
                    <input type="text" name="routes[${routeIndex}][pickup]" placeholder="Kota Asal" class="form-control" style="flex:1;">
                    <input type="text" name="routes[${routeIndex}][dropoff]" placeholder="Kota Tujuan" class="form-control" style="flex:1;">
                    <button type="button" class="btn btn-danger remove-route">✖</button>
                `;
                container.appendChild(newRoute);
                routeIndex++;
                attachRemoveEvent();
            });
        }
        
        function attachRemoveEvent() {
            document.querySelectorAll('.remove-route').forEach(btn => {
                btn.removeEventListener('click', removeRoute);
                btn.addEventListener('click', removeRoute);
            });
        }
        
        function removeRoute(e) {
            e.target.closest('.route-item').remove();
        }
        attachRemoveEvent();
    </script>
</body>
</html>