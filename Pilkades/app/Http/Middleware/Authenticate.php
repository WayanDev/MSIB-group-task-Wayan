<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
        return null;
        }

        $message = 'Anda tidak memiliki akses ke halaman';
        
        try {
            return Redirect::back()->with('error', $message)->getTargetUrl();
        } catch (HttpException $e) {
            // Halaman tidak ditemukan, arahkan ke halaman khusus untuk menampilkan pesan error
            return view('errorpage');
        }
    }
}