<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class JobController extends Controller
{
    public function find(Request $request)
    {
        $keywords = $request->keywords;
        $geoId = $request->geoId;

        // Request GET dengan query params
        $response = Http::post('https://upinganteng123.app.n8n.cloud/webhook-test/jobscrapping', [
            'keywords' => $keywords,
            'geoId' => $geoId
        ]);
        $jobs = null;
        if ($response->successful()) {
            $jobs = $response->json();
        } else {
            $jobs = [];
        }
        return view('browsejobs', compact('jobs'));
    }
}
