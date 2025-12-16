<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;



class CertificateController extends Controller
{

    public function index()
    {
        // [PERBAIKAN] Tambahkan pengecekan autentikasi
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to find certificates.');
        }
        
        // Pastikan variabel results dan keyword ada saat pertama kali buka halaman
        $results = []; 
        $keyword = '';

        return view('certificate', compact('results', 'keyword'));
    }

    // app/Http/Controllers/CertificateController.php

    public function find(Request $request)
    {
        $keyword = $request->keyword;

        // [PERBAIKAN] Ambil URL dari .env (bukan hardcode lagi)
        $certificateUrl = env('N8N_CERTIFICATE_WEBHOOK_URL');

        if (empty($certificateUrl)) {
             // Pengaman jika lupa isi di .env
             return view('certificate', compact('results', 'keyword'))
                ->with('error', 'URL Webhook Certificate belum disetting di file .env.');
        }

        $response = Http::post($certificateUrl, [
            'keyword' => $keyword
        ]);

        // Cek respons dari N8N
        if ($response->successful()) {
            $results = $response->json();

            // Lanjutkan pemrosesan data (array_slice) hanya jika hasil bukan null/kosong
            if (is_array($results) && count($results) > 0) {
                 $results = array_slice($results, 1);
            } else {
                 $results = [];
            }
        } else {
            // Jika gagal konek (404/expired), berikan pesan error
            return view('certificate', compact('results', 'keyword'))
                ->with('error', 'Gagal koneksi ke server N8N. Server mungkin offline.');
            $results = [];
        }

        return view('certificate', compact('results', 'keyword'));
    }
}
