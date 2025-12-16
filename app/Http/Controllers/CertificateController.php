<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;



class CertificateController extends Controller
{

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to find certificates.');
        }
        
        $results = []; 
        $keyword = '';

        return view('certificate', compact('results', 'keyword'));
    }


    public function find(Request $request)
    {
        $keyword = $request->keyword;

        $certificateUrl = env('N8N_CERTIFICATE_WEBHOOK_URL');

        if (empty($certificateUrl)) {
             return view('certificate', compact('results', 'keyword'))
                ->with('error', 'URL Webhook Certificate belum disetting di file .env.');
        }

        $response = Http::post($certificateUrl, [
            'keyword' => $keyword
        ]);

        if ($response->successful()) {
            $results = $response->json();

            if (is_array($results) && count($results) > 0) {
                 $results = array_slice($results, 1);
            } else {
                 $results = [];
            }
        } else {
            return view('certificate', compact('results', 'keyword'))
                ->with('error', 'Gagal koneksi ke server N8N. Server mungkin offline.');
            $results = [];
        }

        return view('certificate', compact('results', 'keyword'));
    }
}
