@extends('layouts.app')

@section('title', 'Hasil Cuaca')

@section('content')
<div class="row">
    {{-- Info Cuaca Sekarang --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">☁️ Cuaca Saat Ini</h5>
            </div>
            <div class="card-body text-center">
                <img src="https://openweathermap.org/img/wn/{{ $cuaca['weather'][0]['icon'] }}@2x.png" alt="cuaca">
                <h3>{{ $cuaca['main']['temp'] }}°C</h3>
                <p class="text-muted">{{ ucfirst($cuaca['weather'][0]['description']) }}</p>
                <hr>
                <p><strong>📍 Lokasi:</strong> {{ $cuaca['name'] }}</p>
                <p><strong>💧 Kelembaban:</strong> {{ $cuaca['main']['humidity'] }}%</p>
                <p><strong>🌬️ Angin:</strong> {{ $cuaca['wind']['speed'] }} m/s</p>
                <p><strong>🌡️ Terasa:</strong> {{ $cuaca['main']['feels_like'] }}°C</p>
                <p><strong>🌱 Jenis Tanaman:</strong> {{ ucfirst($lahan->komoditas) }}</p>
            </div>
        </div>
    </div>

    {{-- Rekomendasi --}}
    <div class="col-md-8 mb-4">
        <div class="card shadow h-100 border-{{ $rekomendasi['status'] }}">
            <div class="card-header bg-{{ $rekomendasi['status'] }} text-white">
                <h5 class="mb-0">{{ $rekomendasi['icon'] }} {{ $rekomendasi['judul'] }}</h5>
            </div>
            <div class="card-body">
                <p class="lead">{{ $rekomendasi['pesan'] }}</p>
                <hr>
                <h6>📋 Saran Kegiatan:</h6>
                <ul>
                    @foreach($rekomendasi['saran'] as $saran)
                        <li>{{ $saran }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Forecast 5 Hari --}}
<div class="card shadow mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">📅 Prakiraan Cuaca 5 Hari ke Depan</h5>
    </div>
    <div class="card-body">
        <div class="row text-center">
            @foreach($forecastHarian as $item)
            <div class="col">
                <div class="card border-0 p-2">
                    <p class="mb-1"><strong>{{ date('D, d M', $item['dt']) }}</strong></p>
                    <img src="https://openweathermap.org/img/wn/{{ $item['weather'][0]['icon'] }}@2x.png" alt="cuaca" width="50">
                    <p class="mb-1">{{ $item['main']['temp'] }}°C</p>
                    <small>{{ ucfirst($item['weather'][0]['description']) }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection