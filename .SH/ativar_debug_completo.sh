#!/bin/bash
# ================================
# Script: Ativação completa de Debug
# Data: 2025-06-12
# Função: Criar Kernel.php, Middleware e Log
# ================================

echo "📁 Criando app/Http/Kernel.php..."
mkdir -p app/Http

cat > app/Http/Kernel.php <<'PHP'
<?php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\RouteDebugMiddleware::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
PHP

echo "🧠 Criando middleware RouteDebugMiddleware..."
mkdir -p app/Http/Middleware

cat > app/Http/Middleware/RouteDebugMiddleware.php <<'PHP'
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class RouteDebugMiddleware
{
    public function handle($request, Closure $next)
    {
        $routeName = Route::currentRouteName() ?? 'rota_anônima';
        $method = $request->method();
        $params = json_encode($request->all());

        Log::channel('routes')->info("🛰️ Rota: $routeName | Método: $method | Parâmetros: $params");

        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response) {
            $content = $response->getContent();
            $banner = "<div style='position:fixed;top:0;left:0;width:100%;background:#222;color:#0f0;padding:2px 10px;font-family:monospace;z-index:9999;font-size:12px;'>🛰️ ROTA: $routeName | MÉTODO: $method</div>";
            $content = str_ireplace("<body>", "<body>$banner", $content);
            $response->setContent($content);
        }

        return $response;
    }
}
PHP

echo "📦 Configurando canal de log 'routes'..."
sed -i "/'channels' => \[/a \        'routes' => [\n            'driver' => 'single',\n            'path' => storage_path('logs/routes_debug.log'),\n            'level' => 'debug',\n        ]," config/logging.php

echo "🔐 Ajustando permissões..."
chown -R www:www .
chmod -R 775 storage bootstrap/cache

echo "✅ Debug completo ativado!"
echo "🛰️ Veja logs em: storage/logs/routes_debug.log"
