@extends('layouts.app')

@section('title', 'Database Admin')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h3>🗄️ Lihat Database</h3>
        <p class="text-muted">Halaman ini hanya bisa diakses oleh Admin.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">👤 Data Users ({{ $users->count() }})</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">🌱 Data Lahan ({{ $lahans->count() }})</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pemilik</th>
                            <th>Nama Lahan</th>
                            <th>Luas</th>
                            <th>Komoditas</th>
                            <th>Kota</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lahans as $lahan)
                        <tr>
                            <td>{{ $lahan->id }}</td>
                            <td>{{ $lahan->user->name ?? '-' }}</td>
                            <td>{{ $lahan->nama_lahan }}</td>
                            <td>{{ $lahan->luas_lahan }}</td>
                            <td>{{ ucfirst($lahan->komoditas) }}</td>
                            <td>{{ $lahan->kota }}</td>
                            <td>{{ $lahan->alamat ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.lahan.edit', $lahan) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.lahan.destroy', $lahan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus lahan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection