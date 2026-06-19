@extends('layouts.app')

@section('title', 'Lihat Database')

@section('content')
<h2 class="mb-3">🗄️ Lihat Database</h2>
<p class="text-muted">Halaman ini hanya bisa diakses oleh Admin.</p>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        👤 Data Users ({{ $users->count() }})
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-success text-white">
        🌱 Data Lahan ({{ $lahans->count() }})
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pemilik</th>
                    <th>Nama Lahan</th>
                    <th>Luas</th>
                    <th>Komoditas</th>
                    <th>Kota</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lahans as $lahan)
                <tr>
                    <td>{{ $lahan->id }}</td>
                    <td>{{ $lahan->user->name ?? '-' }}</td>
                    <td>{{ $lahan->nama_lahan }}</td>
                    <td>{{ $lahan->luas_lahan }}</td>
                    <td>{{ $lahan->komoditas }}</td>
                    <td>{{ $lahan->kota }}</td>
                    <td>{{ $lahan->alamat ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection