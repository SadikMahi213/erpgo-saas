<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class FilterRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $input = $request->all();
        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                $value = strip_tags($value); // Global tag stripping
                $value = preg_replace('/on[a-z]+\s*=\s*"[^"]*"|<[^>]+(on[a-z]+\s*=)/i', '', $value); // Remove event handlers
            }
        });
        $request->merge($input);
        return $next($request);
    }
}
