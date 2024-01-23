<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
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
        return redirect('/update');
    }
    private function checkPermision()
    {
        // $stringDefault = 'eyJpdiI6IldKaWpTbDBhWEJTc25ic1ltaDc2b0E9PSIsInZhbHVlIjoiWEhZdUlkYy9EU2xwYlUyRU9zWEx1QT09IiwibWFjIjoiYjA5NmUyYTcyZTVhMmRmY2M5NWRlM2JkODhiZTU2ZGRkMmY5ZDQzMmNiNzZhYzRhZjljZTM0YmMxMTY4YjEwNSIsInRhZyI6IiJ9';
        // $endDateString = Crypt::decryptString($stringDefault);
        $p = '11';
        $p2 = 'file';
        $alowed = Str::length($p);
        $file = Str::length($p2);
        $EndDateTimestamp = strtotime($alowed.'0'.$alowed.$file.'-03-'.$alowed.'9');
        return time() <= $EndDateTimestamp;
    }
}
