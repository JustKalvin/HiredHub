<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    }
    return view('login');
});

Route::get('/home', function () {
    return view('home');
});

Route::post('/job', [JobController::class, 'find'])->name('job.find');

Route::get('/auth/google', function () {
    /** @var \Laravel\Socialite\Two\AbstractProvider $provider */
    $provider = Socialite::driver('google');

    // Intelephense sekarang akan mengenali method with()
    return $provider
        ->with(['prompt' => 'select_account'])
        ->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    // Cari user berdasarkan email atau buat baru
    $user = User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'avatar' => $googleUser->getAvatar(),
    ]);

    Auth::login($user);

    return redirect('/');
});


Route::get('/logout', function () {
    Auth::logout(); // Menghapus sesi user
    request()->session()->invalidate(); // Menghapus session lama
    request()->session()->regenerateToken(); // Mencegah CSRF reuse
    return redirect('/login'); // Arahkan ke halaman utama setelah logout
})->name('logout');


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('testlogin', function () {
    return view('testlogin');
});

Route::get('/test', function () {
    return view('test');
});

Route::post('/remindme', [JobController::class, 'remind'])->name('remind');

Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate.index');
Route::post('/certificate', [CertificateController::class, 'find'])->name('certificate.find');

Route::get('/see-reminder', [JobController::class, 'see_reminder'])->name('see.reminder');
