@extends('layouts.app')

@section('title', 'Edit Lahan')

@section('content')
<div class="card shadow">
    <div class="card-header bg-warning">
        <h5 class="mb-0">✏️ Edit Lahan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.lahan.update', $lahan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Lahan</label>
                <input type="text" name="nama_lahan" class="form-control" value="{{ old('nama_lahan', $lahan->nama_lahan) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Luas Lahan</label>
                <input type="number" name="luas_lahan" class="form-control" value="{{ old('luas_lahan', $lahan->luas_lahan) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Komoditas</label>
                <input type="text" name="komoditas" class="form-control" value="{{ old('komoditas', $lahan->komoditas) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kota</label>
                <input type="text" name="kota" class="form-control" value="{{ old('kota', $lahan->kota) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat', $lahan->alamat) }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.database') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection