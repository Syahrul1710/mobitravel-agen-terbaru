@extends('agen.layouts.app')

@section('title', 'Tambah Destinasi')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Destinasi Wisata</h2>
        </div>
        
        <form action="{{ route('agen.destinations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Nama Destinasi *</label>
                <input type="text" name="name" class="form-control" required>
                @error('name') <small class="error">{{ $message }}</small> @enderror
            </div>
            
            <div class="form-group">
                <label>Kategori *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <small class="error">{{ $message }}</small> @enderror
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Provinsi *</label>
                        <input type="text" name="province" class="form-control" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Kota *</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Lokasi/Alamat *</label>
                <input type="text" name="location" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Deskripsi *</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Koordinat (opsional)</label>
                <div class="row">
                    <div class="col">
                        <input type="text" name="latitude" placeholder="Latitude" class="form-control">
                    </div>
                    <div class="col">
                        <input type="text" name="longitude" placeholder="Longitude" class="form-control">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Foto Destinasi (minimal 3 foto) *</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                <small>Pilih minimal 3 foto untuk galeri</small>
                @error('images') <small class="error">{{ $message }}</small> @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Destinasi</button>
            <a href="{{ route('agen.destinations.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection