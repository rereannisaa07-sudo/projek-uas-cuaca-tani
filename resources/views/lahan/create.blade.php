@extends('layouts.app')

@section('title', 'Tambah Lahan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
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
                        <input type="number" name="luas_lahan" class="form-control" value="{{ old('luas_lahan', 0) }}" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Tanaman</label>
                        <select name="komoditas" id="komoditas" class="form-select" onchange="toggleKomoditasLain(this)" required>
                            <option value="">-- Pilih Jenis Tanaman --</option>
                            <option value="padi">Padi</option>
                            <option value="jagung">Jagung</option>
                            <option value="sayuran">Sayuran</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3" id="komoditas_lain_wrapper" style="display:none;">
                        <label class="form-label">Tulis Jenis Tanaman</label>
                        <input type="text" name="komoditas_lain" id="komoditas_lain" class="form-control" placeholder="Contoh: Cabai, Tomat, Singkong...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <select name="provinsi" id="provinsi" class="form-select" onchange="loadKota(this)" required>
                            <option value="">-- Pilih Provinsi --</option>
                            <option value="Aceh">Aceh</option>
                            <option value="Sumatera Utara">Sumatera Utara</option>
                            <option value="Sumatera Barat">Sumatera Barat</option>
                            <option value="Riau">Riau</option>
                            <option value="Kepulauan Riau">Kepulauan Riau</option>
                            <option value="Jambi">Jambi</option>
                            <option value="Sumatera Selatan">Sumatera Selatan</option>
                            <option value="Bangka Belitung">Bangka Belitung</option>
                            <option value="Bengkulu">Bengkulu</option>
                            <option value="Lampung">Lampung</option>
                            <option value="DKI Jakarta">DKI Jakarta</option>
                            <option value="Jawa Barat">Jawa Barat</option>
                            <option value="Banten">Banten</option>
                            <option value="Jawa Tengah">Jawa Tengah</option>
                            <option value="DI Yogyakarta">DI Yogyakarta</option>
                            <option value="Jawa Timur">Jawa Timur</option>
                            <option value="Bali">Bali</option>
                            <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                            <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                            <option value="Kalimantan Barat">Kalimantan Barat</option>
                            <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                            <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                            <option value="Kalimantan Timur">Kalimantan Timur</option>
                            <option value="Kalimantan Utara">Kalimantan Utara</option>
                            <option value="Sulawesi Utara">Sulawesi Utara</option>
                            <option value="Gorontalo">Gorontalo</option>
                            <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                            <option value="Sulawesi Barat">Sulawesi Barat</option>
                            <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                            <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                            <option value="Maluku">Maluku</option>
                            <option value="Maluku Utara">Maluku Utara</option>
                            <option value="Papua Barat">Papua Barat</option>
                            <option value="Papua">Papua</option>
                            <option value="Papua Selatan">Papua Selatan</option>
                            <option value="Papua Tengah">Papua Tengah</option>
                            <option value="Papua Pegunungan">Papua Pegunungan</option>
                            <option value="Papua Barat Daya">Papua Barat Daya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kota / Kabupaten</label>
                        <select name="kota" id="kota" class="form-select" required>
                            <option value="">-- Pilih Provinsi Dulu --</option>
                        </select>
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
</div>

<script>
const dataWilayah = {
    "Aceh": ["Banda Aceh","Sabang","Langsa","Lhokseumawe","Subulussalam","Kab. Aceh Besar","Kab. Pidie","Kab. Aceh Utara","Kab. Aceh Timur","Kab. Aceh Selatan","Kab. Aceh Barat","Kab. Aceh Tengah","Kab. Aceh Tenggara","Kab. Simeulue","Kab. Aceh Singkil","Kab. Bireuen","Kab. Aceh Barat Daya","Kab. Gayo Lues","Kab. Nagan Raya","Kab. Aceh Jaya","Kab. Aceh Tamiang","Kab. Bener Meriah","Kab. Pidie Jaya"],
    "Sumatera Utara": ["Medan","Binjai","Tebing Tinggi","Pematangsiantar","Tanjungbalai","Sibolga","Padangsidimpuan","Gunungsitoli","Kab. Deli Serdang","Kab. Langkat","Kab. Karo","Kab. Simalungun","Kab. Asahan","Kab. Labuhanbatu","Kab. Tapanuli Utara","Kab. Tapanuli Tengah","Kab. Tapanuli Selatan","Kab. Nias","Kab. Mandailing Natal","Kab. Toba","Kab. Samosir","Kab. Pakpak Bharat","Kab. Humbang Hasundutan","Kab. Serdang Bedagai","Kab. Batu Bara","Kab. Padang Lawas","Kab. Padang Lawas Utara","Kab. Labuhanbatu Selatan","Kab. Labuhanbatu Utara","Kab. Nias Utara","Kab. Nias Barat","Kab. Nias Selatan"],
    "Sumatera Barat": ["Padang","Bukittinggi","Payakumbuh","Sawahlunto","Solok","Padangpanjang","Pariaman","Kab. Agam","Kab. Tanah Datar","Kab. Lima Puluh Kota","Kab. Pasaman","Kab. Solok","Kab. Sijunjung","Kab. Pesisir Selatan","Kab. Kepulauan Mentawai","Kab. Dharmasraya","Kab. Solok Selatan","Kab. Pasaman Barat"],
    "Riau": ["Pekanbaru","Dumai","Kab. Kampar","Kab. Rokan Hulu","Kab. Bengkalis","Kab. Rokan Hilir","Kab. Pelalawan","Kab. Siak","Kab. Indragiri Hulu","Kab. Indragiri Hilir","Kab. Kuantan Singingi","Kab. Kepulauan Meranti"],
    "Kepulauan Riau": ["Tanjungpinang","Batam","Kab. Bintan","Kab. Karimun","Kab. Natuna","Kab. Lingga","Kab. Kepulauan Anambas"],
    "Jambi": ["Jambi","Sungaipenuh","Kab. Batanghari","Kab. Muaro Jambi","Kab. Tanjung Jabung Timur","Kab. Tanjung Jabung Barat","Kab. Tebo","Kab. Bungo","Kab. Merangin","Kab. Sarolangun","Kab. Kerinci"],
    "Sumatera Selatan": ["Palembang","Prabumulih","Pagar Alam","Lubuklinggau","Kab. Ogan Komering Ulu","Kab. Ogan Komering Ilir","Kab. Muara Enim","Kab. Lahat","Kab. Musi Rawas","Kab. Musi Banyuasin","Kab. Banyuasin","Kab. OKU Timur","Kab. OKU Selatan","Kab. Ogan Ilir","Kab. Empat Lawang","Kab. Penukal Abab Lematang Ilir","Kab. Musi Rawas Utara"],
    "Bangka Belitung": ["Pangkalpinang","Kab. Bangka","Kab. Belitung","Kab. Bangka Barat","Kab. Bangka Tengah","Kab. Bangka Selatan","Kab. Belitung Timur"],
    "Bengkulu": ["Bengkulu","Kab. Bengkulu Utara","Kab. Bengkulu Selatan","Kab. Rejang Lebong","Kab. Kepahiang","Kab. Lebong","Kab. Mukomuko","Kab. Seluma","Kab. Kaur","Kab. Bengkulu Tengah"],
    "Lampung": ["Bandar Lampung","Metro","Kab. Lampung Selatan","Kab. Lampung Tengah","Kab. Lampung Utara","Kab. Lampung Barat","Kab. Tulang Bawang","Kab. Tanggamus","Kab. Lampung Timur","Kab. Way Kanan","Kab. Pesawaran","Kab. Pringsewu","Kab. Mesuji","Kab. Tulang Bawang Barat","Kab. Pesisir Barat"],
    "DKI Jakarta": ["Jakarta Pusat","Jakarta Utara","Jakarta Barat","Jakarta Selatan","Jakarta Timur","Kab. Kepulauan Seribu"],
    "Jawa Barat": ["Bandung","Bekasi","Bogor","Cimahi","Cirebon","Depok","Sukabumi","Tasikmalaya","Banjar","Kab. Bandung","Kab. Bandung Barat","Kab. Bekasi","Kab. Bogor","Kab. Ciamis","Kab. Cianjur","Kab. Cirebon","Kab. Garut","Kab. Indramayu","Kab. Karawang","Kab. Kuningan","Kab. Majalengka","Kab. Pangandaran","Kab. Purwakarta","Kab. Subang","Kab. Sukabumi","Kab. Sumedang","Kab. Tasikmalaya"],
    "Banten": ["Serang","Cilegon","Tangerang","Tangerang Selatan","Kab. Serang","Kab. Pandeglang","Kab. Lebak","Kab. Tangerang"],
    "Jawa Tengah": ["Semarang","Surakarta","Salatiga","Magelang","Pekalongan","Tegal","Kab. Banjarnegara","Kab. Banyumas","Kab. Batang","Kab. Blora","Kab. Boyolali","Kab. Brebes","Kab. Cilacap","Kab. Demak","Kab. Grobogan","Kab. Jepara","Kab. Karanganyar","Kab. Kebumen","Kab. Kendal","Kab. Klaten","Kab. Kudus","Kab. Magelang","Kab. Pati","Kab. Pekalongan","Kab. Pemalang","Kab. Purbalingga","Kab. Purworejo","Kab. Rembang","Kab. Semarang","Kab. Sragen","Kab. Sukoharjo","Kab. Tegal","Kab. Temanggung","Kab. Wonogiri","Kab. Wonosobo"],
    "DI Yogyakarta": ["Yogyakarta","Kab. Bantul","Kab. Sleman","Kab. Gunungkidul","Kab. Kulon Progo"],
    "Jawa Timur": ["Surabaya","Malang","Batu","Blitar","Kediri","Madiun","Mojokerto","Pasuruan","Probolinggo","Kab. Bangkalan","Kab. Banyuwangi","Kab. Blitar","Kab. Bojonegoro","Kab. Bondowoso","Kab. Gresik","Kab. Jember","Kab. Jombang","Kab. Kediri","Kab. Lamongan","Kab. Lumajang","Kab. Madiun","Kab. Magetan","Kab. Malang","Kab. Mojokerto","Kab. Nganjuk","Kab. Ngawi","Kab. Pacitan","Kab. Pamekasan","Kab. Pasuruan","Kab. Ponorogo","Kab. Probolinggo","Kab. Sampang","Kab. Sidoarjo","Kab. Situbondo","Kab. Sumenep","Kab. Trenggalek","Kab. Tuban","Kab. Tulungagung"],
    "Bali": ["Denpasar","Kab. Badung","Kab. Bangli","Kab. Buleleng","Kab. Gianyar","Kab. Jembrana","Kab. Karangasem","Kab. Klungkung","Kab. Tabanan"],
    "Nusa Tenggara Barat": ["Mataram","Bima","Kab. Lombok Barat","Kab. Lombok Tengah","Kab. Lombok Timur","Kab. Lombok Utara","Kab. Sumbawa","Kab. Sumbawa Barat","Kab. Dompu","Kab. Bima"],
    "Nusa Tenggara Timur": ["Kupang","Kab. Kupang","Kab. Timor Tengah Selatan","Kab. Timor Tengah Utara","Kab. Belu","Kab. Alor","Kab. Flores Timur","Kab. Sikka","Kab. Ende","Kab. Ngada","Kab. Manggarai","Kab. Sumba Timur","Kab. Sumba Barat","Kab. Lembata","Kab. Rote Ndao","Kab. Manggarai Barat","Kab. Nagekeo","Kab. Sumba Tengah","Kab. Sumba Barat Daya","Kab. Manggarai Timur","Kab. Sabu Raijua","Kab. Malaka"],
    "Kalimantan Barat": ["Pontianak","Singkawang","Kab. Sambas","Kab. Bengkayang","Kab. Landak","Kab. Mempawah","Kab. Sanggau","Kab. Sekadau","Kab. Sintang","Kab. Melawi","Kab. Kapuas Hulu","Kab. Ketapang","Kab. Kayong Utara","Kab. Kubu Raya"],
    "Kalimantan Tengah": ["Palangka Raya","Kab. Kotawaringin Barat","Kab. Kotawaringin Timur","Kab. Kapuas","Kab. Barito Selatan","Kab. Barito Utara","Kab. Katingan","Kab. Seruyan","Kab. Sukamara","Kab. Lamandau","Kab. Gunung Mas","Kab. Pulang Pisau","Kab. Murung Raya","Kab. Barito Timur"],
    "Kalimantan Selatan": ["Banjarmasin","Banjarbaru","Kab. Banjar","Kab. Barito Kuala","Kab. Tapin","Kab. Hulu Sungai Selatan","Kab. Hulu Sungai Tengah","Kab. Hulu Sungai Utara","Kab. Tabalong","Kab. Tanah Laut","Kab. Kotabaru","Kab. Tanah Bumbu","Kab. Balangan"],
    "Kalimantan Timur": ["Samarinda","Balikpapan","Bontang","Kab. Kutai Kartanegara","Kab. Kutai Barat","Kab. Kutai Timur","Kab. Berau","Kab. Paser","Kab. Penajam Paser Utara","Kab. Mahakam Ulu"],
    "Kalimantan Utara": ["Tarakan","Kab. Bulungan","Kab. Malinau","Kab. Nunukan","Kab. Tana Tidung"],
    "Sulawesi Utara": ["Manado","Bitung","Tomohon","Kotamobagu","Kab. Minahasa","Kab. Minahasa Utara","Kab. Minahasa Selatan","Kab. Minahasa Tenggara","Kab. Bolaang Mongondow","Kab. Bolaang Mongondow Utara","Kab. Bolaang Mongondow Timur","Kab. Bolaang Mongondow Selatan","Kab. Kepulauan Sangihe","Kab. Kepulauan Talaud","Kab. Kepulauan Siau Tagulandang Biaro"],
    "Gorontalo": ["Gorontalo","Kab. Gorontalo","Kab. Boalemo","Kab. Bone Bolango","Kab. Pohuwato","Kab. Gorontalo Utara"],
    "Sulawesi Tengah": ["Palu","Kab. Donggala","Kab. Poso","Kab. Morowali","Kab. Banggai","Kab. Banggai Kepulauan","Kab. Toli-Toli","Kab. Buol","Kab. Parigi Moutong","Kab. Tojo Una-Una","Kab. Sigi","Kab. Banggai Laut","Kab. Morowali Utara"],
    "Sulawesi Barat": ["Mamuju","Kab. Polewali Mandar","Kab. Mamasa","Kab. Majene","Kab. Mamuju Tengah","Kab. Pasangkayu"],
    "Sulawesi Selatan": ["Makassar","Parepare","Palopo","Kab. Gowa","Kab. Takalar","Kab. Jeneponto","Kab. Bantaeng","Kab. Bulukumba","Kab. Sinjai","Kab. Bone","Kab. Soppeng","Kab. Wajo","Kab. Sidenreng Rappang","Kab. Pinrang","Kab. Enrekang","Kab. Luwu","Kab. Luwu Utara","Kab. Luwu Timur","Kab. Tana Toraja","Kab. Toraja Utara","Kab. Maros","Kab. Pangkajene dan Kepulauan","Kab. Barru","Kab. Selayar"],
    "Sulawesi Tenggara": ["Kendari","Bau-Bau","Kab. Konawe","Kab. Konawe Selatan","Kab. Konawe Utara","Kab. Konawe Kepulauan","Kab. Kolaka","Kab. Kolaka Utara","Kab. Kolaka Timur","Kab. Bombana","Kab. Buton","Kab. Buton Utara","Kab. Buton Tengah","Kab. Buton Selatan","Kab. Muna","Kab. Muna Barat","Kab. Wakatobi"],
    "Maluku": ["Ambon","Tual","Kab. Maluku Tengah","Kab. Maluku Tenggara","Kab. Maluku Tenggara Barat","Kab. Kepulauan Aru","Kab. Seram Bagian Barat","Kab. Seram Bagian Timur","Kab. Buru","Kab. Buru Selatan","Kab. Kepulauan Tanimbar"],
    "Maluku Utara": ["Ternate","Tidore Kepulauan","Kab. Halmahera Barat","Kab. Halmahera Tengah","Kab. Halmahera Utara","Kab. Halmahera Selatan","Kab. Halmahera Timur","Kab. Kepulauan Sula","Kab. Pulau Taliabu","Kab. Pulau Morotai"],
    "Papua Barat": ["Manokwari","Sorong","Kab. Sorong","Kab. Sorong Selatan","Kab. Raja Ampat","Kab. Teluk Bintuni","Kab. Teluk Wondama","Kab. Kaimana","Kab. Fakfak","Kab. Manokwari Selatan","Kab. Pegunungan Arfak"],
    "Papua": ["Jayapura","Kab. Jayapura","Kab. Keerom","Kab. Sarmi","Kab. Biak Numfor","Kab. Kepulauan Yapen","Kab. Waropen","Kab. Mamberamo Raya"],
    "Papua Selatan": ["Kab. Merauke","Kab. Boven Digoel","Kab. Mappi","Kab. Asmat"],
    "Papua Tengah": ["Kab. Nabire","Kab. Paniai","Kab. Puncak Jaya","Kab. Puncak","Kab. Dogiyai","Kab. Intan Jaya","Kab. Deiyai"],
    "Papua Pegunungan": ["Kab. Jayawijaya","Kab. Pegunungan Bintang","Kab. Yahukimo","Kab. Tolikara","Kab. Mamberamo Tengah","Kab. Yalimo","Kab. Lanny Jaya","Kab. Nduga","Kab. Puncak"],
    "Papua Barat Daya": ["Kab. Sorong","Kab. Sorong Selatan","Kab. Raja Ampat","Kab. Tambrauw","Kab. Maybrat"]
};

function loadKota(select) {
    var kotaSelect = document.getElementById('kota');
    var provinsi = select.value;
    kotaSelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
    if (provinsi && dataWilayah[provinsi]) {
        dataWilayah[provinsi].forEach(function(kota) {
            var option = document.createElement('option');
            option.value = kota;
            option.text = kota;
            kotaSelect.appendChild(option);
        });
    }
}

function toggleKomoditasLain(select) {
    var wrapper = document.getElementById('komoditas_lain_wrapper');
    var input = document.getElementById('komoditas_lain');
    if (select.value === 'lainnya') {
        wrapper.style.display = 'block';
        input.required = true;
    } else {
        wrapper.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}
</script>
@endsection