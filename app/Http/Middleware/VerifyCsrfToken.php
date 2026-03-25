<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs that should be excluded from CSRF verification.
     * Use relative paths (no domain), without a leading slash.
     */
    protected $except = [
        'Jfeid/login',      // <-- change to your actual panel login path if different
        // 'Jfeid/login',    // e.g. uncomment if your login is actually /Jfeid/login
    ];
}
