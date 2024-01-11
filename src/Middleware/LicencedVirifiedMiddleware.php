<?php

namespace Shumonpal\ProjectSecurity\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shumonpal\ProjectSecurity\Traits\UtilityTrait;

class LicencedVirifiedMiddleware
{
    use UtilityTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->licence()?->code) {
            return $next($request);
        }
        return redirect(route('project-security.licences'));
    }
}
