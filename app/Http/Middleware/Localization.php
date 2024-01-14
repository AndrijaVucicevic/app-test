<?php

namespace App\Http\Middleware;

use App\Enums\LanguageEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->input('lang');
        if ($lang && in_array($lang, LanguageEnum::values())) {
            app()->setLocale($lang);
        } else {
            app()->setlocale('en');
        }
        return $next($request);
    }
}
