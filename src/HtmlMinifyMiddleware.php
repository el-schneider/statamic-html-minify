<?php

namespace Octoper\HtmlMinify;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HtmlMinifyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        // Skip minification if disabled or in debug mode
        if ($this->shouldSkipMinification()) {
            return $response;
        }

        if ($response instanceof StreamedResponse || $response instanceof JsonResponse) {
            return $response;
        }

        if ($response instanceof Response && $this->isValidHTMLResponse($response)) {
            try {
                $html = (new HtmlMinify($response->getContent()))->minifiedHtml();
                return $response->setContent($html);
            } catch (Exception $e) {
                // Log the error but don't break the response
                Log::warning('HTML minification failed', [
                    'error' => $e->getMessage(),
                    'url' => $request->url(),
                ]);
            }
        }

        return $response;
    }

    /**
     * Determine if minification should be skipped.
     */
    protected function shouldSkipMinification(): bool
    {
        // Skip if minification is disabled
        if (!config('html-minify.enabled', true)) {
            return true;
        }

        // Skip if in debug mode and skip_on_debug is enabled
        if (config('html-minify.skip_on_debug', false) && config('app.debug', false)) {
            return true;
        }

        return false;
    }

    /**
     * Check if the response contains HTML content.
     */
    protected function isValidHTMLResponse(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');

        return stripos($contentType, 'text/html') !== false;
    }
}
