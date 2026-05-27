@extends('admin.layouts.app')

@section('title', 'Detail Agen')
@section('menu-agents', 'active')

@section('content')
<div class="content">
    <div class="header">
        <h1>Detail Agen</h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>
    
    <div class="card">
        <div class="info-row">
            <div class="info-label">ID Agen</div>
            <div class="info-value">#{{ $agent->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">NIK</div>
            <div class="info-value">{{ $agent->nik ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nama Agen</div>
            <div class="info-value">{{ $agent->agency_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $agent->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Telepon</div>
            <div class="info-value">{{ $agent->phone ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">WhatsApp</div>
            <div class="info-value">{{ $agent->whatsapp ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kota / Provinsi</div>
            <div class="info-value">{{ $agent->city }}, {{ $agent->province ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Alamat</div>
            <div class="info-value">{{ $agent->address ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Deskripsi</div>
            <div class="info-value">{{ $agent->description ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">
                <span class="status status-{{ $agent->status }}">
                    {{ ucfirst($agent->status) }}
                </span>
            </div>
        </div>
        @if($agent->rejected_reason)
        <div class="info-row">
            <div class="info-label">Alasan Ditolak</div>
            <div class="info-value">
                @if($agent->created_at)
                    {{ \Carbon\Carbon::parse($agent->created_at)->format('d/m/Y H:i') }}
                @else
                    -
                @endif
            </div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">Tanggal Daftar</div>
            <div class="info-value">{{ $agent->created_at->format('d/m/Y H:i') }}</div>
        </div>
        @if($agent->verified_at)
        <div class="info-row">
            <div class="info-label">Tanggal Verifikasi</div>
            <div class="info-value">
                @if($agent->verified_at && $agent->verified_at != '0000-00-00 00:00:00')
                    {{ \Carbon\Carbon::parse($agent->verified_at)->format('d/m/Y H:i') }}
                @else
                    -
                @endif
            </div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">Foto KTP</div>
            <div class="info-value">
                @if($agent->ktp_photo)
                    <img src="{{ asset('storage/' . $agent->ktp_photo) }}" class="ktp-photo">
                @else
                    <em>Belum upload KTP</em>
                @endif
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="{{ url()->previous() }}" class="btn btn-back">← Kembali</a>
        
        @if($agent->status == 'pending')
            <form method="POST" action="{{ route('admin.agents.verify', $agent->id) }}" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-primary">Setujui Agen</button>
            </form>
            
            <button onclick="showRejectModal()" class="btn btn-warning">Tolak Agen</button>
        @endif
        
        @if($agent->status == 'active')
            <button onclick="suspendAgent()" class="btn btn-warning">Tangguhkan</button>
        @endif
        
        @if($agent->status == 'suspended')
            <button onclick="activateAgent()" class="btn btn-primary">Aktifkan Kembali</button>
        @endif
        
        <button onclick="deleteAgent()" class="btn btn-danger">Hapus Agen</button>
    </div>
</div>

<!-- Modal Tolak -->
<div id="rejectModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:12px; width:400px;">
        <h3>Tolak Agen</h3>
        <p>Agen: <strong>{{ $agent->agency_name }}</strong></p>
        <form id="rejectForm" method="POST" action="{{ route('admin.agents.reject', $agent->id) }}">
            @csrf
            <textarea name="reason" rows="4" placeholder="Alasan penolakan..." style="width:100%; margin:15px 0; padding:8px;" required></textarea>
            <button type="submit" class="btn btn-warning">Ya, Tolak</button>
            <button type="button" onclick="closeModal()" class="btn btn-danger">Batal</button>
        </form>
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
    }
    .card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .info-row {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    .info-label {
        width: 180px;
        font-weight: bold;
        color: #666;
    }
    .info-value {
        flex: 1;
        color: #333;
    }
    .ktp-photo {
        max-width: 300px;
        margin-top: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
    }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-active { background: #dcfce7; color: #16a34a; }
    .status-suspended { background: #fee2e2; color: #dc2626; }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }
    .btn-primary { background: #1a3328; color: white; }
    .btn-warning { background: #d97706; color: white; }
    .btn-danger { background: #dc2626; color: white; }
    .btn-back { background: #666; color: white; }
</style>

<script>
    function showRejectModal() {
        document.getElementById('rejectModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }
    
    function suspendAgent() {
        if(confirm('Yakin ingin menangguhkan agen ini?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.agents.suspend", $agent->id) }}';
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function activateAgent() {
        if(confirm('Yakin ingin mengaktifkan kembali agen ini?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.agents.activate", $agent->id) }}';
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function deleteAgent() {
        if(confirm('Yakin ingin menghapus agen ini secara permanen?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.agents.destroy", $agent->id) }}';
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    window.onclick = function(event) {
        let modal = document.getElementById('rejectModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection