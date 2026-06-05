<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuacaTani - Hasil Cuaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🌾 CuacaTani</a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('cuaca.index') }}" class="btn btn-outline-light btn-sm">🌤️ Cek Cuaca Lagi</a>
            <a href="{{ route('lahan.index') }}" class="btn btn-outline-light btn-sm">🌱 Data Lahan</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4">
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
                    <p><strong>🌱 Komoditas:</strong> {{ ucfirst($lahan->komoditas) }}</p>
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
                    <div class="card border-0 bg-light p-2">
                        <p class="mb-1"><strong>{{ date('D, d M', $item['dt']) }}</strong></p>
                        <img src="https://openweathermap.org/img/wn/{{ $item['weather'][0]['icon'] }}@2x.png" alt="cuaca" width="50">
                        <p class="mb-1">{{ $item['main']['temp'] }}°C</p>
                        <small class="text-muted">{{ ucfirst($item['weather'][0]['description']) }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</body>
</html>
