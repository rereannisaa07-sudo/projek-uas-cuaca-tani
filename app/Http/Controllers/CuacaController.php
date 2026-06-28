<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CuacaController extends Controller
{
    public function index()
    {
        $lahans = Lahan::where('user_id', Auth::id())->get();
        return view('cuaca.index', compact('lahans'));
    }

    public function cekCuaca(Request $request)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahans,id',
        ]);

        $lahan = Lahan::findOrFail($request->lahan_id);
        $apiKey = env('OPENWEATHER_API_KEY');
        $kota = $this->getNamaKotaAPI($lahan->kota);

        // Ambil cuaca current
        $cuacaResponse = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q'     => $kota,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'id',
        ]);

        // Ambil forecast 5 hari
        $forecastResponse = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
            'q'     => $kota,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'id',
        ]);

        if ($cuacaResponse->failed()) {
            return back()->with('error', 'Kota tidak ditemukan! Periksa nama kota pada data lahan.');
        }

        $cuaca = $cuacaResponse->json();
        $forecast = $forecastResponse->json();

        // Ambil 1 data per hari (setiap 24 jam)
        $forecastHarian = [];
        $tanggalDicatat = [];
        foreach ($forecast['list'] as $item) {
            $tanggal = date('Y-m-d', $item['dt']);
            if (!in_array($tanggal, $tanggalDicatat)) {
                $forecastHarian[] = $item;
                $tanggalDicatat[] = $tanggal;
                if (count($forecastHarian) >= 5) break;
            }
        }

        // Logika rekomendasi
        $rekomendasi = $this->getRekomendasi(
            $cuaca['weather'][0]['main'],
            $lahan->komoditas,
            $cuaca['main']['temp'],
            $cuaca['main']['humidity']
        );

        return view('cuaca.hasil', compact('cuaca', 'forecastHarian', 'lahan', 'rekomendasi'));
    }

    private function getNamaKotaAPI($kota)
    {
        // Hapus prefix "Kab." atau "Kabupaten"
        $kota = preg_replace('/^(Kab\.|Kabupaten)\s*/i', '', $kota);

        // Mapping kota khusus yang tidak dikenali OpenWeatherMap
        $mapping = [
            'Jakarta Pusat'      => 'Jakarta',
            'Jakarta Utara'      => 'Jakarta',
            'Jakarta Barat'      => 'Jakarta',
            'Jakarta Selatan'    => 'Jakarta',
            'Jakarta Timur'      => 'Jakarta',
            'Kepulauan Seribu'   => 'Jakarta',
            'Tangerang Selatan'  => 'Tangerang',
            'Depok'              => 'Depok',
            'Bekasi'             => 'Bekasi',
            'Bogor'              => 'Bogor',
            'Bandung Barat'      => 'Bandung',
            'Cimahi'             => 'Bandung',
            'Surakarta'          => 'Solo',
            'Pematangsiantar'    => 'Pematang Siantar',
            'Bau-Bau'            => 'Baubau',
            'Tidore Kepulauan'   => 'Tidore',
            'Pangkajene dan Kepulauan' => 'Pangkajene',
            'Tojo Una-Una'       => 'Ampana',
            'Siau Tagulandang Biaro' => 'Siau',
            'Hulu Sungai Selatan' => 'Kandangan',
            'Hulu Sungai Tengah' => 'Barabai',
            'Hulu Sungai Utara'  => 'Amuntai',
            'Penajam Paser Utara' => 'Penajam',
            'Kotawaringin Barat' => 'Pangkalan Bun',
            'Kotawaringin Timur' => 'Sampit',
            'Bolaang Mongondow'  => 'Kotamobagu',
            'Kepulauan Aru'      => 'Dobo',
            'Kepulauan Talaud'   => 'Melonguane',
            'Kepulauan Sangihe'  => 'Tahuna',
            'Maluku Tenggara Barat' => 'Saumlaki',
            'Seram Bagian Barat' => 'Piru',
            'Seram Bagian Timur' => 'Bula',
            'Teluk Bintuni'      => 'Bintuni',
            'Teluk Wondama'      => 'Wasior',
            'Pegunungan Arfak'   => 'Manokwari',
            'Mamberamo Raya'     => 'Burmeso',
            'Boven Digoel'       => 'Tanah Merah',
        ];

        return $mapping[$kota] ?? $kota;
    }

    private function getRekomendasi($kondisiCuaca, $komoditas, $suhu, $kelembaban)
    {
        $kondisi = strtolower($kondisiCuaca);
        $komoditas = strtolower($komoditas);

        $hujan = str_contains($kondisi, 'rain') || str_contains($kondisi, 'drizzle') || str_contains($kondisi, 'thunderstorm');
        $panas = str_contains($kondisi, 'clear') || str_contains($kondisi, 'sunny') || $suhu >= 32;
        $berawan = str_contains($kondisi, 'cloud');

        // === PADI ===
        if ($komoditas === 'padi') {
            if ($hujan) {
                return [
                    'status' => 'warning', 'icon' => '🌧️',
                    'judul' => 'Cuaca Hujan - Tunda Pemupukan!',
                    'pesan' => 'Hujan tidak ideal untuk pemupukan padi. Tunda hingga cuaca cerah agar pupuk tidak larut.',
                    'saran' => [
                        'Tunda kegiatan pemupukan',
                        'Pastikan drainase sawah berfungsi baik',
                        'Periksa ketinggian air di sawah',
                        'Waspadai hama dan penyakit akibat kelembaban tinggi',
                    ]
                ];
            } elseif ($panas) {
                return [
                    'status' => 'danger', 'icon' => '☀️',
                    'judul' => 'Cuaca Panas - Jaga Ketinggian Air Sawah!',
                    'pesan' => 'Suhu ' . $suhu . '°C terlalu panas untuk padi. Pastikan air sawah cukup agar tanaman tidak stres.',
                    'saran' => [
                        'Pastikan ketinggian air sawah 5-10 cm',
                        'Hindari pemupukan saat terik (pupuk mudah menguap)',
                        'Lakukan pemupukan pagi hari sebelum jam 09.00',
                        'Pantau tanaman dari gejala daun menggulung',
                    ]
                ];
            } else {
                return [
                    'status' => 'success', 'icon' => '⛅',
                    'judul' => 'Cuaca Ideal untuk Padi!',
                    'pesan' => 'Kondisi berawan sangat cocok untuk aktivitas perawatan padi.',
                    'saran' => [
                        'Waktu terbaik untuk pemupukan',
                        'Cocok untuk penanaman bibit padi',
                        'Lakukan penyiangan gulma',
                        'Periksa kondisi irigasi sawah',
                    ]
                ];
            }
        }

        // === JAGUNG ===
        elseif ($komoditas === 'jagung') {
            if ($hujan) {
                return [
                    'status' => 'warning', 'icon' => '🌧️',
                    'judul' => 'Cuaca Hujan - Waspadai Busuk Akar!',
                    'pesan' => 'Hujan deras bisa menyebabkan busuk akar pada jagung. Pastikan drainase lahan baik.',
                    'saran' => [
                        'Tunda pemupukan',
                        'Periksa dan perbaiki saluran drainase',
                        'Waspadai penyakit bulai akibat kelembaban tinggi',
                        'Tunda penyemprotan pestisida',
                    ]
                ];
            } elseif ($panas) {
                return [
                    'status' => 'danger', 'icon' => '☀️',
                    'judul' => 'Cuaca Panas - Segera Siram Jagung!',
                    'pesan' => 'Suhu ' . $suhu . '°C berbahaya untuk jagung, terutama saat fase berbunga. Segera lakukan penyiraman.',
                    'saran' => [
                        'Siram pagi (06.00-08.00) dan sore (16.00-18.00)',
                        'Hindari penyiraman saat siang terik',
                        'Tunda pemupukan hingga suhu turun',
                        'Pantau tanaman dari gejala layu',
                    ]
                ];
            } else {
                return [
                    'status' => 'success', 'icon' => '⛅',
                    'judul' => 'Cuaca Ideal untuk Jagung!',
                    'pesan' => 'Kondisi berawan sangat cocok untuk perawatan jagung.',
                    'saran' => [
                        'Waktu terbaik untuk pemupukan NPK',
                        'Cocok untuk penanaman jagung baru',
                        'Lakukan pembumbunan tanah',
                        'Periksa hama penggerek batang',
                    ]
                ];
            }
        }

        // === SAYURAN ===
        elseif ($komoditas === 'sayuran') {
            if ($hujan) {
                return [
                    'status' => 'warning', 'icon' => '🌧️',
                    'judul' => 'Cuaca Hujan - Lindungi Sayuran!',
                    'pesan' => 'Hujan lebat bisa merusak sayuran. Segera ambil tindakan perlindungan.',
                    'saran' => [
                        'Pasang naungan plastik jika memungkinkan',
                        'Tunda pemupukan dan penyemprotan',
                        'Periksa drainase bedengan',
                        'Waspadai penyakit jamur pada daun',
                    ]
                ];
            } elseif ($panas) {
                return [
                    'status' => 'danger', 'icon' => '☀️',
                    'judul' => 'Cuaca Panas - Sayuran Butuh Air!',
                    'pesan' => 'Suhu ' . $suhu . '°C terlalu panas untuk sayuran. Siram segera agar tidak layu.',
                    'saran' => [
                        'Siram 2x sehari pagi dan sore',
                        'Pasang mulsa untuk menjaga kelembaban tanah',
                        'Beri naungan pada sayuran daun',
                        'Hindari pemupukan saat siang hari',
                    ]
                ];
            } else {
                return [
                    'status' => 'success', 'icon' => '⛅',
                    'judul' => 'Cuaca Ideal untuk Sayuran!',
                    'pesan' => 'Kondisi berawan sangat baik untuk pertumbuhan sayuran.',
                    'saran' => [
                        'Waktu terbaik untuk pemupukan organik',
                        'Cocok untuk pindah tanam bibit sayuran',
                        'Lakukan penyiangan gulma',
                        'Semprotkan pestisida organik jika perlu',
                    ]
                ];
            }
        }

        // === LAINNYA ===
        else {
            if ($hujan) {
                return [
                    'status' => 'warning', 'icon' => '🌧️',
                    'judul' => 'Cuaca Hujan - Tunda Pemupukan!',
                    'pesan' => 'Kondisi hujan tidak ideal untuk pemupukan. Tunda hingga cuaca membaik.',
                    'saran' => [
                        'Tunda pemupukan',
                        'Periksa drainase lahan',
                        'Waspadai hama dan penyakit',
                    ]
                ];
            } elseif ($panas) {
                return [
                    'status' => 'danger', 'icon' => '☀️',
                    'judul' => 'Cuaca Panas - Lakukan Penyiraman!',
                    'pesan' => 'Suhu ' . $suhu . '°C cukup panas. Segera siram tanaman agar tidak kekeringan.',
                    'saran' => [
                        'Siram pagi dan sore hari',
                        'Tunda pemupukan saat terik',
                        'Pantau kelembaban tanah',
                    ]
                ];
            } else {
                return [
                    'status' => 'success', 'icon' => '⛅',
                    'judul' => 'Cuaca Kondusif untuk Bertani!',
                    'pesan' => 'Kondisi cuaca saat ini baik untuk aktivitas pertanian.',
                    'saran' => [
                        'Lanjutkan jadwal tanam normal',
                        'Waktu baik untuk pemupukan',
                        'Periksa kondisi tanaman',
                    ]
                ];
            }
        }
    }
}