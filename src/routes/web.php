<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Http\Request;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\PesanKontak;
use App\Models\PengaturanWebsite;

/*
|--------------------------------------------------------------------------
| Livewire Asset Handling
|--------------------------------------------------------------------------
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

/*
|--------------------------------------------------------------------------
| Front Website
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $pengaturan = PengaturanWebsite::first();

    return view('welcome', [
        'pengaturan' => $pengaturan,

        'kategoriMenus' => KategoriMenu::withCount('menus')
            ->latest()
            ->get(),

        'menus' => Menu::with('kategoriMenu')
            ->where('status', 'Tersedia')
            ->latest()
            ->get(),

        'menuFavorit' => Menu::where('status', 'Tersedia')
            ->latest()
            ->first(),

        'ulasans' => Ulasan::with(['pelanggan', 'pesanan'])
            ->latest()
            ->take(6)
            ->get(),

        'pesanans' => Pesanan::with('pelanggan')
            ->latest()
            ->get(),

        'jumlahPesanan' => Pesanan::count(),
        'jumlahMenu' => Menu::count(),
        'jumlahPelanggan' => Pelanggan::count(),
        'ratingRataRata' => Ulasan::avg('rating') ?? 0,
    ]);
});

/*
|--------------------------------------------------------------------------
| Pesan Kontak
|--------------------------------------------------------------------------
*/

Route::post('/pesan-kontak', function (Request $request) {
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subjek' => 'required|string|max:255',
        'pesan' => 'required|string',
    ]);

    PesanKontak::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'subjek' => $request->subjek,
        'pesan' => $request->pesan,
        'status' => 'Belum Dibaca',
    ]);

    return redirect('/#kontak')->with('success', 'Pesan kamu berhasil dikirim.');
})->name('pesan-kontak.store');

/*
|--------------------------------------------------------------------------
| Ulasan Pelanggan
|--------------------------------------------------------------------------
*/

Route::post('/ulasan', function (Request $request) {
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'no_hp' => 'required|string|max:20',
        'alamat' => 'required|string',
        'pesanan_id' => 'required|exists:pesanans,id',
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'required|string',
    ]);

    $pelanggan = Pelanggan::firstOrCreate(
        ['email' => $request->email],
        [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]
    );

    Ulasan::create([
        'pelanggan_id' => $pelanggan->id,
        'pesanan_id' => $request->pesanan_id,
        'rating' => $request->rating,
        'komentar' => $request->komentar,
    ]);

    return redirect('/#ulasan')->with('success', 'Ulasan kamu berhasil dikirim.');
})->name('ulasan.store');