<?php

namespace App\Http\Controllers;

use App\Models\UserRemind;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    public function find(Request $request)
    {
        $keywords = $request->input('keywords');
        $geoId = $request->input('geoId');
        $file = $request->file('file');

        $jobScrappingUrl = env('N8N_JOB_SCRAPPING_WEBHOOK_URL');

        if (empty($jobScrappingUrl)) {
             return view('browsejobs', compact('jobs', 'keywords', 'geoId'))
                ->with('error', 'Link Webhook N8N belum disetting di .env');
        }

        if ($file) {
            $response = Http::attach(
                'file',                      
                file_get_contents($file),    
                $file->getClientOriginalName() 
            )->post($jobScrappingUrl, [
                'keywords' => $keywords,
                'geoId' => $geoId
            ]);
        }
        else {
            $response = Http::post($jobScrappingUrl, [
                'keywords' => $keywords,
                'geoId' => $geoId
            ]);
        }

        // Cek respons dari N8N
        if ($response->successful()) {
            $jobs = $response->json();
            // Jaga-jaga kalau datanya bukan array
            if (!is_array($jobs)) $jobs = [];
        } else {
            $jobs = [];
        }

        return view('browsejobs', compact('jobs', 'keywords', 'geoId'));
    }

    public function remind(Request $request)
    {
        // 1. mastiin user sudah login (Redirect ke login kalau belum)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first to set a reminder.');
        }

        // Ambil data dan ubah ke lowercase
        $email = strtolower(Auth::user()->email);
        $keyword = strtolower($request->keywords);
        $geoId = strtolower($request->geoId);

        // Cek apakah data sudah ada
        $existing = UserRemind::where('user_email', $email)
            ->where('user_keyword', $keyword)
            ->first();

        // Kalau ada, kembaliin dengan pesan warning 
        if ($existing) {
            return redirect()->back()->with('warning', 'You already have an active reminder for "' . $request->keywords . '"');
        }

        // Simpan ke database lokal
        $remind = UserRemind::create([
            'user_email' => $email,
            'user_keyword' => $keyword,
            'user_geoId' => $geoId
        ]);

        $remindInsertUrl = env('N8N_REMIND_INSERT_WEBHOOK_URL');

        if ($remindInsertUrl) {
            // Kirim data ke N8N
            try {
                $response = Http::post($remindInsertUrl, [
                    'user_email' => $remind->user_email,
                    'user_keyword' => $remind->user_keyword,
                    'user_geoId' => $remind->user_geoId,
                ]);

                // Log jika gagal
                if ($response->failed()) {
                    Log::error('Gagal kirim ke N8N', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error koneksi N8N: ' . $e->getMessage());
            }
        }

        return redirect()->route('job', [
            'keywords' => $request->input('keywords'),
            'geoId' => $request->input('geoId')
        ])->with('success', 'Reminder set successfully! We will notify you.');
    }

    // --- 2. FUNCTION Lihat Reminder) ---
    public function see_reminder()
    {
        // A. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $email = Auth::user()->email;
        
        // Ambil URL dari .env
        $seeReminderUrl = env('N8N_SEE_REMINDER_WEBHOOK_URL');
        if (empty($seeReminderUrl)) {
             return view('seereminder', ['reminders' => []])
                ->with('error', 'Webhook URL belum disetting di file .env');
        }

        // B. Kirim ke N8N
        try {
            $response = Http::post($seeReminderUrl, [
                'user_email' => $email,
            ]);
        } catch (\Throwable $e) {
            return view('seereminder', ['reminders' => []])
                ->with('error', 'Gagal koneksi ke server.');
        }

        // C. Tangani Response
        if ($response->successful()) {
            $reminders = $response->json();
            
            if (!is_array($reminders)) {
                $reminders = [];
            }

            return view('seereminder', [
                'reminders' => $reminders,
            ]);
        }

        return view('seereminder', [
            'reminders' => [],
        ])->with('error', 'Gagal memuat data.');
    }
}
