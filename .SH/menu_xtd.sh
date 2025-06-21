#!/bin/bash

PROJECT_PATH="/www/wwwroot/erp.xtd.com.br"
LAYOUT_FILE="$PROJECT_PATH/resources/views/layouts/app.blade.php"
ROUTE_FILE="$PROJECT_PATH/routes/web.php"

echo "🔄 Inserindo menu lateral fixo mantendo estrutura Blade..."

# Atualiza o layout, sem remover a estrutura original
cat > "$LAYOUT_FILE" <<'BLADE'
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ERP XTD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- MENU LATERAL FIXO -->
<nav class="bg-white shadow w-60 fixed h-full z-50 border-r border-gray-200">
    <div class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-800">ERP XTD</h2>
        <ul class="mt-6 space-y-2 text-sm font-medium text-gray-600">
            <li>
                <details class="group">
                    <summary class="flex items-center cursor-pointer px-3 py-2 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4.992 4.992 0 011 13V7a5 5 0 0110 0v6a4.992 4.992 0 01-4.121 4.804M15 21h.01M19 21h.01M17 17h.01M17 13h.01" /></svg>
                        Contatos
                    </summary>
                    <ul class="pl-8 mt-1 space-y-1 text-sm">
                        <li><a href="{{ route('contatos.index') }}" class="block py-1 hover:text-blue-500">Listar Contatos</a></li>
                        <li><a href="{{ route('contatos.create') }}" class="block py-1 hover:text-blue-500">Novo Contato</a></li>
                    </ul>
                </details>
            </li>
            <li>
                <details class="group">
                    <summary class="flex items-center cursor-pointer px-3 py-2 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.657 0 3-.895 3-2s-1.343-2-3-2-3 .895-3 2 1.343 2 3 2zM6 22V12H4a2 2 0 00-2 2v6a2 2 0 002 2h2zm12 0v-6a2 2 0 00-2-2h-2v10h4a2 2 0 002-2z" /></svg>
                        Financeiro
                    </summary>
                    <ul class="pl-8 mt-1 space-y-1 text-sm">
                        <li><a href="{{ route('financeiro.receber.index') }}" class="block py-1 hover:text-green-500">Contas a Receber</a></li>
                        <li><a href="{{ route('financeiro.pagar.index') }}" class="block py-1 hover:text-green-500">Contas a Pagar</a></li>
                    </ul>
                </details>
            </li>
        </ul>
    </div>
</nav>

<!-- CONTEÚDO -->
<main class="ml-60 p-6">
    @yield('content')
</main>

</body>
</html>
BLADE

# Rotas
grep -q "Route::resource('contatos'" $ROUTE_FILE || echo "Route::resource('contatos', App\\Http\\Controllers\\ContatoController::class);" >> $ROUTE_FILE

grep -q "Route::prefix('financeiro')" $ROUTE_FILE || cat <<EOL >> $ROUTE_FILE

Route::prefix('financeiro')->group(function () {
    Route::resource('receber', App\\Http\\Controllers\\ContasReceberController::class);
    Route::resource('pagar', App\\Http\\Controllers\\ContasPagarController::class);
});
EOL

# Permissões
chown -R www:www $PROJECT_PATH
chmod -R 775 $PROJECT_PATH/storage $PROJECT_PATH/bootstrap/cache

echo "✅ Menu fixo lateral reimplementado mantendo compatibilidade Blade."
