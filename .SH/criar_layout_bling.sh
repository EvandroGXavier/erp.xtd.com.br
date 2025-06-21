#!/bin/bash
# ================================
# Script: Layout estilo Bling
# Data: 2025-06-09
# Função: Criar menu fixo superior com Bootstrap
# Execução: chmod +x && ./criar_layout_bling.sh
# ================================

mkdir -p resources/views/layouts

echo "📦 Criando layout base em: layouts/app.blade.php"
cat > resources/views/layouts/app.blade.php <<'EOL'
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') — ERP XTD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
      body { padding-top: 56px; }
      .navbar-fixed { position: fixed; top: 0; width: 100%; z-index: 1030; height: 56px; }
      .nav-link { font-family: 'Segoe UI', sans-serif; font-size: .9rem; }
    </style>
    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom navbar-fixed">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('dashboard') }}">ERP XTD</a>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link" href="{{ route('contatos.index') }}">Contatos</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('financeiro.index') }}">Contas a Receber</a></li>
    </ul>
    <span class="navbar-text">
      <a href="#" class="nav-link">Sair</a>
    </span>
  </div>
</nav>
<main class="container-fluid mt-3">
  @yield('content')
</main>
</body>
</html>
EOL

echo "✏️ Atualizando views existentes para usar layout..."
for VIEW in contato_list contato_form financeiro_list financeiro_form; do
  FILE="resources/views/${VIEW}.blade.php"
  if [ -f "$FILE" ]; then
    mv "$FILE" "$FILE.bak"
    echo "@extends('layouts.app')" > "$FILE"
    echo "@section('title', '$(echo $VIEW | sed 's/_/ /g')')" >> "$FILE"
    echo "@section('content')" >> "$FILE"
    cat "$FILE.bak" >> "$FILE"
    echo "@endsection" >> "$FILE"
    rm "$FILE.bak"
  fi
done

echo "🔐 Ajustando permissões..."
chown -R www:www storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "✅ Layout atualizado com sucesso! Acesse: http://erp.xtd.com.br"
