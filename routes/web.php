<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// =============================================================
// RUTE UNTUK GUEST (Belum Login)
// =============================================================

// Rute Halaman Utama (Redirect Login/Home)
Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    }
    return view('login');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/logout', function () {
    Auth::logout(); 
    request()->session()->invalidate(); 
    request()->session()->regenerateToken(); 
    return redirect('/login');
})->name('logout');


// --- Socialite Auth ---
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'avatar' => $googleUser->getAvatar(),
    ]);

    Auth::login($user);

    // Arahkan ke halaman utama setelah login
    return redirect('/'); 
});


// =============================================================
// RUTE YANG MEMBUTUHKAN LOGIN (Middleware 'auth')
// =============================================================

Route::middleware(['auth'])->group(function () {
    
    // --- Rute Navigasi Utama ---
    Route::get('/home', function () { return view('home'); });
// about
    Route::get('/about', function () { 
        return view('about'); 
    })->name('about');
    
    // --- Rute Job Finder & Reminder ---
    Route::match(['get', 'post'], '/job', [JobController::class, 'find'])->name('job');
    Route::post('/remindme', [JobController::class, 'remind'])->name('remind');
    
    // --- Rute Certificate ---
    Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate.index');
    Route::post('/certificate', [CertificateController::class, 'find'])->name('certificate.find');

    Route::get('/see-reminder', [JobController::class, 'see_reminder'])->name('see.reminder');
    
    // --- Rute Testing ---
    Route::get('testlogin', function () { return view('testlogin'); });
    Route::get('/test', function () { return view('test'); });
});
