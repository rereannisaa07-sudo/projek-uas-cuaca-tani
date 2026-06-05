<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuacaTani - Data Lahan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🌾 CuacaTani</a>
        <div class="ms-auto">
            <span class="text-white me-3">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>🌱 Data Lahan Saya</h4>
        <a href="{{ route('lahan.create') }}" class="btn btn-success">+ Tambah Lahan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th>Nama Lahan</th>
                    <th>Luas (Ha)</th>
                    <th>Komoditas</th>
                    <th>Kota</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lahans as $key => $lahan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $lahan->nama_lahan }}</td>
                    <td>{{ $lahan->luas_lahan }}</td>
                    <td>{{ ucfirst($lahan->komoditas) }}</td>
                    <td>{{ $lahan->kota }}</td>
                    <td>{{ $lahan->alamat ?? '-' }}</td>
                    <td>
                        <a href="{{ route('lahan.edit', $lahan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('lahan.destroy', $lahan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus lahan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data lahan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>