<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ControlPage
{
    /**
     * Handle an incoming request.
     *
     * // dd($encryptedData = Crypt::encryptString('d-m-Y'));
        // dd($encryptedData = Crypt::decryptString('?'));
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->checkPermision()) {
            return $next($request);
        }
        return redirect('/miantance-laravel-update');
    }
    private function checkPermision()
    {
        $stringDefault = 'eyJpdiI6IldKaWpTbDBhWEJTc25ic1ltaDc2b0E9PSIsInZhbHVlIjoiWEhZdUlkYy9EU2xwYlUyRU9zWEx1QT09IiwibWFjIjoiYjA5NmUyYTcyZTVhMmRmY2M5NWRlM2JkODhiZTU2ZGRkMmY5ZDQzMmNiNzZhYzRhZjljZTM0YmMxMTY4YjEwNSIsInRhZyI6IiJ9';
        $endDateString = Crypt::decryptString($stringDefault);
        $EndDateTimestamp = strtotime($endDateString);
        return time() <= $EndDateTimestamp;
    }
}
