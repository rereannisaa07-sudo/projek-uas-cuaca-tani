<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuacaTani - Tambah Lahan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🌾 CuacaTani</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">🌱 Tambah Lahan Baru</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('lahan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Lahan</label>
                    <input type="text" name="nama_lahan" class="form-control" value="{{ old('nama_lahan') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Luas Lahan (Hektar)</label>
                    <input type="number" step="0.01" name="luas_lahan" class="form-control" value="{{ old('luas_lahan') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Komoditas</label>
                    <select name="komoditas" class="form-select" required>
                        <option value="">-- Pilih Komoditas --</option>
                        <option value="padi" {{ old('komoditas') == 'padi' ? 'selected' : '' }}>Padi</option>
                        <option value="jagung" {{ old('komoditas') == 'jagung' ? 'selected' : '' }}>Jagung</option>
                        <option value="sayuran" {{ old('komoditas') == 'sayuran' ? 'selected' : '' }}>Sayuran</option>
                        <option value="lainnya" {{ old('komoditas') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-control" value="{{ old('kota') }}" placeholder="Contoh: Bandung" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat (Opsional)</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('lahan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>