#!/bin/bash
# ================================
# Script: Corrigir Layout/Menu Fixo
# Data: 2025-06-12
# Função: Corrigir layout superior e views para usar menu fixo
# Execução: chmod +x && ./corrigir_layout_menu.sh
# ================================

echo "📦 Criando layout base atualizada..."
mkdir -p resources/views/layouts
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
    <span class="navbar-text"><a href="#" class="nav-link">Sair</a></span>
  </div>
</nav>
<main class="container-fluid mt-3">
  @yield('content')
</main>
</body>
</html>
EOL

echo "✏️ Atualizando todas as views existentes para usar o layout..."

for VIEW in dashboard contato_list contato_form financeiro_list financeiro_form; do
  FILE="resources/views/\${VIEW}.blade.php"
  if [ -f "\$FILE" ]; then
    mv "\$FILE" "\$FILE.bak"
    echo "@extends('layouts.app')" > "\$FILE"
    echo "@section('title', ucfirst('\$(echo \$VIEW | sed 's/_/ /g')'))" >> "\$FILE"
    echo "@section('content')" >> "\$FILE"
    cat "\$FILE.bak" >> "\$FILE"
    echo "@endsection" >> "\$FILE"
    rm "\$FILE.bak"
    echo "🔹 \$VIEW atualizado."
  fi
done

echo "🔐 Ajustando permissões..."
chown -R www:www storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "✅ Layout/menu fixo corrigidos! Teste no navegador."
