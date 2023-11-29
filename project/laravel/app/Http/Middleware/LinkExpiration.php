<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class LinkExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /*public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }*/


    public function handle($request, Closure $next)
    {
        // Получаем время перехода пользователя по ссылке
        $linkClickedAt = session('link_clicked_at');

        // Проверяем, прошло ли 1 день с момента перехода по ссылке
        if ($linkClickedAt && Carbon::parse($linkClickedAt)->addSeconds(10)->isPast()) {
            // Если прошло 1 день, делаем сайт недоступным
            abort(403, 'Ссылка больше недействительна.');
        }

        return $next($request);
    }
}
