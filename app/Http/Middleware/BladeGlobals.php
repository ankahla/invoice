<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Model\InvoiceReceived;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BladeGlobals
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            View::share('newInvoicesReceived', InvoiceReceived::where('user_id', Auth::id())->where('status', 0)->count());
        }

        return $next($request);
    }
}
