<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RouteDebugMiddleware
{
    public function handle($request, Closure $next)
    {
        $routeName = Route::currentRouteName() ?: 'rota_anônima';
        $method = $request->method();
        $params = json_encode($request->all());

        Log::channel('routes')->info("🛰️ Rota: $routeName | Método: $method | Parâmetros: $params");

        $response = $next($request);

        if ($response instanceof Response && strpos($response->headers->get('Content-Type'), 'text/html') !== false) {
            $content = $response->getContent();
            $banner = "<div style='position:fixed;top:0;left:0;width:100%;background:#222;color:#0f0;padding:2px 10px;font-family:monospace;z-index:9999;font-size:12px;'>🛰️ ROTA: $routeName | MÉTODO: $method</div>";
            $content = str_ireplace('<body>', '<body>'.$banner, $content);
            $response->setContent($content);
        }

        return $response;
    }
}
