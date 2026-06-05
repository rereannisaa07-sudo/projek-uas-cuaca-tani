@extends('layouts.app')

@section('title', 'Cek Cuaca')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">🌤️ Cek Cuaca Lahan</h5>
            </div>
            <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('lahan.create') }}" class="btn btn-success btn-sm">+ Tambah Lahan Baru</a>
</div>
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
@endsection