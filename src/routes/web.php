<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            return redirect()->intended(route('pelanggan.dashboard'));
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

        return redirect(route('pelanggan.dashboard'))->with('success', 'Registrasi berhasil! Selamat datang ' . $pelanggan->nama);
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
| Pelanggan Dashboard (Area Pelanggan)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:pelanggan')->prefix('dashboard')->name('pelanggan.')->group(function () {
    Route::get('/', function () {
        $pelanggan = Auth::guard('pelanggan')->user();
        $pesananSemua = $pelanggan->pesanans()->with('detailPesanans')->latest()->get();

        return view('pelanggan.dashboard', [
            'pengaturan' => PengaturanWebsite::first(),
            'totalPesanan' => $pesananSemua->count(),
            'pesananDiproses' => $pesananSemua->whereIn('status', ['Baru', 'Diproses'])->count(),
            'pesananSelesai' => $pesananSemua->where('status', 'Selesai')->count(),
            'ratingRata' => $pelanggan->ulasans()->avg('rating') ?? 0,
            'pesananTerbaru' => $pesananSemua->take(5),
        ]);
    })->name('dashboard');

    Route::get('/pesanan', function (Request $request) {
        $pelanggan = Auth::guard('pelanggan')->user();
        $query = $pelanggan->pesanans()->with('detailPesanans');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return view('pelanggan.pesanan.index', [
            'pengaturan' => PengaturanWebsite::first(),
            'pesanans' => $query->latest()->get(),
        ]);
    })->name('pesanan');

    Route::get('/pesanan/{id}', function ($id) {
        $pelanggan = Auth::guard('pelanggan')->user();
        $pesanan = $pelanggan->pesanans()->with('detailPesanans.menu')->findOrFail($id);

        return view('pelanggan.pesanan.show', [
            'pengaturan' => PengaturanWebsite::first(),
            'pesanan' => $pesanan,
        ]);
    })->name('pesanan.show');

    Route::get('/profil', function () {
        $pelanggan = Auth::guard('pelanggan')->user();

        return view('pelanggan.profil', [
            'pengaturan' => PengaturanWebsite::first(),
            'pelanggan' => $pelanggan,
            'totalPesanan' => $pelanggan->pesanans()->count(),
            'totalUlasan' => $pelanggan->ulasans()->count(),
        ]);
    })->name('profil');

    Route::put('/profil', function (Request $request) {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $pelanggan->update($request->only(['nama', 'email', 'no_hp', 'alamat']));

        return redirect()->route('pelanggan.profil')->with('profile_updated', true)->with('success', 'Profil berhasil diperbarui!');
    })->name('profil.update');

    Route::put('/password', function (Request $request) {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $pelanggan->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $pelanggan->update(['password' => bcrypt($request->new_password)]);

        return redirect()->route('pelanggan.profil')->with('password_updated', true)->with('success', 'Password berhasil diganti!');
    })->name('password.update');
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