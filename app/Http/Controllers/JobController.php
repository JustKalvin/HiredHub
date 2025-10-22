<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    public function find(Request $request)
    {
        $keywords = $request->input('keywords');
        $geoId = $request->input('geoId');
        $file = $request->file('file');

        // Pastikan file ada sebelum mengirim
        // if (!$file) {
        //     return back()->with('error', 'File PDF tidak ditemukan.');
        // }

        // Kirim request POST ke N8N dengan multipart/form-data
        $response = Http::attach(
            'file',                      // nama field file
            file_get_contents($file),    // isi file
            $file->getClientOriginalName() // nama file aslinya
        )->post('https://upinganteng123.app.n8n.cloud/webhook-test/jobscrapping', [
            'keywords' => $keywords,
            'geoId' => $geoId
        ]);

        // Cek respons dari N8N
        if ($response->successful()) {
            $jobs = $response->json();
        } else {
            $jobs = [];
        }

        return view('browsejobs', compact('jobs'));
    }
}
