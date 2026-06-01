<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket Wisata - MobiTravel Agen</title>
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
        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }
        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
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
        <li><a href="{{ route('agen.tour-packages.index') }}" class="active">Paket Wisata</a></li>
        <li><a href="#">Pemesanan</a></li>
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
            <h2>Edit Paket Wisata</h2>
        </div>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('agen.tour-packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Destinasi *</label>
                <select name="destination_id" class="form-control" required>
                    <option value="">Pilih Destinasi</option>
                    @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}" {{ $package->destination_id == $dest->id ? 'selected' : '' }}>
                        {{ $dest->name }} - {{ $dest->city }}
                    </option>
                    @endforeach
                </select>
                @error('destination_id') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Kategori *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $package->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id') <div class="error">{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label>Nama Paket *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $package->name) }}" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Durasi *</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration', $package->duration) }}" required placeholder="Contoh: 3 Hari 2 Malam">
                    @error('duration') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $package->price) }}" required>
                    @error('price') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Kuota Peserta *</label>
                    <input type="number" name="quota" class="form-control" value="{{ old('quota', $package->quota) }}" required>
                    @error('quota') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="available" {{ $package->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="sold_out" {{ $package->status == 'sold_out' ? 'selected' : '' }}>Habis</option>
                        <option value="disabled" {{ $package->status == 'disabled' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Deskripsi *</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $package->description) }}</textarea>
                @error('description') <div class="error">{{ $message }}</div> @enderror
            </div>
            
            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">💾 Update Paket</button>
                <a href="{{ route('agen.tour-packages.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>