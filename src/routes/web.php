<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
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
| Pelanggan Auth
|--------------------------------------------------------------------------
*/

Route::middleware('guest:pelanggan')->group(function () {
    Route::get('/login', function () {
        $pengaturan = PengaturanWebsite::first();
        return view('auth.login', ['pengaturan' => $pengaturan]);
    })->name('pelanggan.login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('pelanggan')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    });

    Route::get('/register', function () {
        $pengaturan = PengaturanWebsite::first();
        return view('auth.register', ['pengaturan' => $pengaturan]);
    })->name('pelanggan.register');

    Route::post('/register', function (Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'password' => bcrypt($request->password),
        ]);

        Auth::guard('pelanggan')->login($pelanggan);

        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang ' . $pelanggan->nama);
    });
});

Route::post('/logout', function (Request $request) {
    Auth::guard('pelanggan')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('pelanggan.logout');

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

        'ulasans' => Ulasan::with(['pelanggan', 'pesanan'])
            ->latest()
            ->take(6)
            ->get(),

        'pesanans' => Pesanan::with('pelanggan')
            ->latest()
            ->get(),

        'jumlahKategori' => KategoriMenu::count(),
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
| Pemesanan Online
|--------------------------------------------------------------------------
*/

Route::post('/pesan', function (Request $request) {
    $items = json_decode($request->items, true) ?? [];
    $request->merge(['items' => $items]);

    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'no_hp' => 'required|string|max:20',
        'tanggal_acara' => 'required|date',
        'alamat_pengiriman' => 'required|string',
        'catatan' => 'nullable|string|max:500',
        'items' => 'required|array|min:1',
        'items.*.menu_id' => 'required|exists:menus,id',
        'items.*.jumlah' => 'required|integer|min:1',
    ]);

    $pelanggan = Pelanggan::firstOrCreate(
        ['email' => $request->email],
        [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat_pengiriman,
        ]
    );

    $totalHarga = 0;
    $detailItems = [];

    foreach ($request->items as $item) {
        $menu = Menu::findOrFail($item['menu_id']);
        $subtotal = $menu->harga * $item['jumlah'];
        $totalHarga += $subtotal;

        $detailItems[] = new DetailPesanan([
            'menu_id' => $menu->id,
            'jumlah' => $item['jumlah'],
            'harga' => $menu->harga,
            'subtotal' => $subtotal,
        ]);
    }

    $pesanan = Pesanan::create([
        'pelanggan_id' => $pelanggan->id,
        'tanggal_pesanan' => now(),
        'tanggal_acara' => $request->tanggal_acara,
        'alamat_pengiriman' => $request->alamat_pengiriman,
        'total_harga' => $totalHarga,
        'status' => 'Baru',
        'catatan' => $request->catatan,
    ]);

    $pesanan->detailPesanans()->saveMany($detailItems);

    return redirect('/?order_success=1')->with('success', 'Pesanan berhasil dikirim! Admin akan menghubungi kamu.');
})->name('pesan.store');

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