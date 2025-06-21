#!/bin/bash
# ================================
# Script: Ativar Debug de Roteamento
# Data: 2025-06-12
# Função: Mostrar rota atual + método + parâmetros
# Execução: chmod +x && ./ativar_debug_rotas.sh
# ================================

echo "🧠 Criando middleware RouteDebugMiddleware..."
mkdir -p app/Http/Middleware

cat > app/Http/Middleware/RouteDebugMiddleware.php <<'EOL'
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
EOL

echo "🔄 Verificando Kernel.php..."
if [ -f "app/Http/Kernel.php" ]; then
    sed -i "/protected \$middleware = \[/a \ \ \ \ \ \ App\\\\Http\\\\Middleware\\\\RouteDebugMiddleware::class," app/Http/Kernel.php
else
    echo "❌ Arquivo Kernel.php não encontrado. Verifique se está em app/Http/"
fi

echo "📦 Adicionando canal de log exclusivo..."
cp config/logging.php config/logging.php.bak
awk '/channels.*=>.*\[/ {
    print;
    print "        '\''routes'\'' => [";
    print "            '\''driver'\'' => '\''single'\'',";
    print "            '\''path'\'' => storage_path('\''logs/routes_debug.log'\''),";
    print "            '\''level'\'' => '\''debug'\'',";
    print "        ],";
    next
}1' config/logging.php.bak > config/logging.php

echo "🔐 Ajustando permissões..."
touch storage/logs/routes_debug.log
chown -R www:www storage bootstrap/cache
chmod -R 775 storage/logs

echo "✅ Debug de rotas ativado!"
echo "🛰️ Veja logs: storage/logs/routes_debug.log"
