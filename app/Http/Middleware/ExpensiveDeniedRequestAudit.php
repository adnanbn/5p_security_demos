<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ExpensiveDeniedRequestAudit
{
    public function handle(Request $request, Closure $next): Response
    {
        DB::table('users')->count();
        DB::table('cache')->updateOrInsert(
            ['key' => 'denial:'.$request->attributes->get('request_id')],
            [
                'value' => json_encode([
                    'path' => '/'.$request->path(),
                    'source_ip' => $request->ip(),
                ], JSON_THROW_ON_ERROR),
                'expiration' => now()->addDay()->timestamp,
            ],
        );

        Log::channel('security')->warning('security.unknown_route_denied', [
            'request_id' => $request->attributes->get('request_id'),
            'path' => '/'.$request->path(),
        ]);

        return $next($request);
    }
}
