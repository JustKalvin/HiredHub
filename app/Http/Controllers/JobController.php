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

        // Jika ada file, kirim dengan attach()
        if ($file) {
            $response = Http::attach(
                'file',                      // nama field file
                file_get_contents($file),    // isi file
                $file->getClientOriginalName() // nama file aslinya
            )->post('https://upinganteng123.app.n8n.cloud/webhook-test/jobscrapping', [
                'keywords' => $keywords,
                'geoId' => $geoId
            ]);
        }
        // Jika tidak ada file, kirim tanpa attach()
        else {
            $response = Http::post('https://upinganteng123.app.n8n.cloud/webhook-test/jobscrapping', [
                'keywords' => $keywords,
                'geoId' => $geoId
            ]);
        }

        // Cek respons dari N8N
        if ($response->successful()) {
            $jobs = $response->json();
        } else {
            $jobs = [];
        }

        return view('browsejobs', compact('jobs', 'keywords', 'geoId'));
    }

    public function remind(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json(['error' => 'User belum login'], 401);
        }

        // Ambil data dan ubah ke lowercase
        $email = strtolower(Auth::user()->email);
        $keyword = strtolower($request->keywords);
        $geoId = strtolower($request->geoId);

        // Cek apakah kombinasi email + keyword sudah ada
        $existing = UserRemind::where('user_email', $email)
            ->where('user_keyword', $keyword)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Data sudah ada, tidak perlu insert ulang.',
                'data' => $existing
            ]);
        }

        // Jika belum ada, simpan ke database
        $remind = UserRemind::create([
            'user_email' => $email,
            'user_keyword' => $keyword,
            'user_geoId' => $geoId
        ]);

        // Kirim data ke N8N
        $response = Http::post('https://upinganteng123.app.n8n.cloud/webhook-test/inserttrigger', [
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

        return view('home');
    }
}
