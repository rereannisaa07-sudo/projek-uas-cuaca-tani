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
        $kota = $lahan->kota;

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
        $rekomendasi = $this->getRekomendasi($cuaca['weather'][0]['main'], $lahan->komoditas);

        return view('cuaca.hasil', compact('cuaca', 'forecastHarian', 'lahan', 'rekomendasi'));
    }

    private function getRekomendasi($kondisiCuaca, $komoditas)
    {
        $kondisi = strtolower($kondisiCuaca);

        if (str_contains($kondisi, 'rain') || str_contains($kondisi, 'drizzle') || str_contains($kondisi, 'thunderstorm')) {
            return [
                'status' => 'warning',
                'icon' => '🌧️',
                'judul' => 'Cuaca Hujan - Tunda Pemupukan!',
                'pesan' => 'Kondisi hujan saat ini tidak ideal untuk pemupukan. Tunda pemupukan hingga cuaca cerah agar pupuk tidak larut terbawa air hujan.',
                'saran' => [
                    'Tunda kegiatan pemupukan',
                    'Pastikan drainase lahan berfungsi baik',
                    'Periksa kondisi tanaman dari potensi banjir',
                    'Siapkan plastik penutup untuk pupuk yang sudah ada',
                ]
            ];
        } elseif (str_contains($kondisi, 'clear') || str_contains($kondisi, 'sunny')) {
            return [
                'status' => 'danger',
                'icon' => '☀️',
                'judul' => 'Cuaca Panas - Lakukan Penyiraman!',
                'pesan' => 'Cuaca cerah dan panas. Segera lakukan penyiraman pada tanaman ' . $komoditas . ' agar tidak kekeringan.',
                'saran' => [
                    'Lakukan penyiraman pagi hari (06.00-08.00)',
                    'Lakukan penyiraman sore hari (16.00-18.00)',
                    'Waktu ideal untuk pemupukan setelah penyiraman',
                    'Pantau kelembaban tanah secara berkala',
                ]
            ];
        } elseif (str_contains($kondisi, 'cloud')) {
            return [
                'status' => 'success',
                'icon' => '⛅',
                'judul' => 'Cuaca Berawan - Kondisi Ideal!',
                'pesan' => 'Cuaca berawan adalah kondisi terbaik untuk aktivitas pertanian ' . $komoditas . '.',
                'saran' => [
                    'Waktu ideal untuk pemupukan',
                    'Cocok untuk penanaman bibit baru',
                    'Lakukan pemangkasan tanaman',
                    'Cek dan perbaiki irigasi lahan',
                ]
            ];
        } else {
            return [
                'status' => 'info',
                'icon' => '🌤️',
                'judul' => 'Pantau Cuaca Secara Berkala',
                'pesan' => 'Kondisi cuaca saat ini normal. Lanjutkan aktivitas pertanian seperti biasa.',
                'saran' => [
                    'Pantau perkembangan cuaca',
                    'Lanjutkan jadwal tanam normal',
                    'Periksa kondisi tanaman',
                ]
            ];
        }
    }
}