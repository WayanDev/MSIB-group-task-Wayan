<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use App\Models\akunDesa;
use App\Models\Kandidat;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function showVotingResults(Request $request)
    {
        $response = Http::get('https://peserta61.msib.hendevane.com/api/voting-results');

        if ($response->successful()) {
            $responseData = $response->json();
            $dataPerDesa = $responseData['data'];
            return view('home', compact('dataPerDesa'));
        } else {
            $errorMessage = $response->json()['message'];
            return view('home', compact('errorMessage'));
        }
    }
}
