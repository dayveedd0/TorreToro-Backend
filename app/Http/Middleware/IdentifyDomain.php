<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        // If domain query parameter is provided in a request with session (e.g. ?domain=uk), persist to session
        if ($request->has('domain') && $request->hasSession()) {
            $queryCode = strtolower(trim((string) $request->query('domain')));
            if (Domain::where('code', $queryCode)->where('is_active', true)->exists()) {
                session(['admin_domain_code' => $queryCode]);
            }
        }

        $domain = Domain::resolveFromRequest();

        // Bind current active domain to service container as singleton instance for this request
        app()->instance(Domain::class, $domain);

        $response = $next($request);

        // Add domain headers to response for debugging
        $response->headers->set('X-Active-Domain', $domain->code);

        return $response;
    }
}
