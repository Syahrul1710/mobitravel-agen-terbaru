@extends('agen.layouts.app')

@section('title', 'Tambah Paket Wisata')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Paket Wisata</h2>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('agen.tour-packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Destinasi *</label>
                <select name="destination_id" class="form-control" required>
                    <option value="">-- Pilih Destinasi --</option>
                    @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}" {{ old('destination_id') == $dest->id ? 'selected' : '' }}>
                        {{ $dest->name }} - {{ $dest->city }}, {{ $dest->province }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Nama Paket *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Eksplorasi Bromo Sunrise">
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Durasi *</label>
                        <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" required placeholder="Contoh: 3 Hari 2 Malam">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Harga (Rp) *</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required placeholder="Contoh: 2500000">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Kuota Peserta *</label>
                        <input type="number" name="quota" class="form-control" value="{{ old('quota') }}" required placeholder="Contoh: 20">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Deskripsi *</label>
                <textarea name="description" class="form-control" rows="5" required placeholder="Jelaskan itinerary, fasilitas, dan hal-hal yang termasuk dalam paket...">{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Foto Paket (minimal 2 foto) *</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                <small>Pilih minimal 2 foto untuk galeri paket wisata (JPG, PNG, maks 2MB per file)</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Paket</button>
            <a href="{{ route('agen.tour-packages.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection