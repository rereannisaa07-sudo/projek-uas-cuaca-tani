<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuacaTani - Edit Lahan</title>
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
        <div class="card-header bg-warning">
            <h5 class="mb-0">✏️ Edit Lahan</h5>
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

            <form action="{{ route('lahan.update', $lahan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Lahan</label>
                    <input type="text" name="nama_lahan" class="form-control" value="{{ $lahan->nama_lahan }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Luas Lahan (Hektar)</label>
                    <input type="number" step="0.01" name="luas_lahan" class="form-control" value="{{ $lahan->luas_lahan }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Komoditas</label>
                    <select name="komoditas" class="form-select" required>
                        <option value="padi" {{ $lahan->komoditas == 'padi' ? 'selected' : '' }}>Padi</option>
                        <option value="jagung" {{ $lahan->komoditas == 'jagung' ? 'selected' : '' }}>Jagung</option>
                        <option value="sayuran" {{ $lahan->komoditas == 'sayuran' ? 'selected' : '' }}>Sayuran</option>
                        <option value="lainnya" {{ $lahan->komoditas == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-control" value="{{ $lahan->kota }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat (Opsional)</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ $lahan->alamat }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a href="{{ route('lahan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>