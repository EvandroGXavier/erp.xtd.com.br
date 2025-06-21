<?php
/**
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 12/06/2025
 * Função: Registrar middleware global, grupos de middleware e middleware de rota
 * Nome do Arquivo: Kernel.php
 * Localização: /www/wwwroot/erp.xtd.com.br/app/Http/Kernel.php
 * 
 * Estrutura:
 *  1. Namespace e imports (linhas 1-4)
 *  2. Classe Kernel estendendo HttpKernel (linha 6)
 *  3. Middleware Global (protected $middleware) (linhas 8-14)
 *  4. Grupos de Middleware (protected $middlewareGroups) (linhas 16-25)
 *  5. Middleware de Rota (protected $routeMiddleware) (linhas 27-32)
 */

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // 3. Middleware Global: executados em todas as requisições
    protected $middleware = [
        \App\Http\Middleware\RouteDebugMiddleware::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    // 4. Grupos de Middleware: aplicados conforme grupo (web, api, etc.)
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

    // 5. Middleware de Rota: usados individualmente nas rotas
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
