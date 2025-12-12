<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CertificateController extends Controller
{
    //
    public function index()
    {
        return view('certificate');
    }

    public function find(Request $request)
    {
        $keyword = $request->keyword;
        $certificateUrl = env('N8N_CERTIFICATE_WEBHOOK_URL');
        $response = Http::post($certificateUrl, [
            'keyword' => $keyword
        ]);

        $results = $response->json();

        $results = array_slice($results, 1);

        return view('certificate', compact('results', 'keyword'));
    }
}
