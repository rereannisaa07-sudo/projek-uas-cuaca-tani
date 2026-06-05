<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuacaTani - Cek Cuaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🌾 CuacaTani</a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('lahan.index') }}" class="btn btn-outline-light btn-sm">🌱 Data Lahan</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🌤️ Cek Cuaca Lahan</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if($lahans->isEmpty())
                        <div class="alert alert-warning">
                            Belum ada data lahan. <a href="{{ route('lahan.create') }}">Tambah lahan dulu</a>.
                        </div>
                    @else
                        <form action="{{ route('cuaca.cek') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Pilih Lahan</label>
                                <select name="lahan_id" class="form-select" required>
                                    <option value="">-- Pilih Lahan --</option>
                                    @foreach($lahans as $lahan)
                                        <option value="{{ $lahan->id }}">
                                            {{ $lahan->nama_lahan }} - {{ $lahan->kota }} ({{ ucfirst($lahan->komoditas) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">🔍 Cek Cuaca Sekarang</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>