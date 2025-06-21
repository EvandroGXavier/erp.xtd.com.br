#!/bin/bash
# ================================
# Script: Reinstalar Módulo Contatos
# Data: 2025-06-12
# PHP: 8.3 com alias artisan
# Execução: chmod +x && ./criar_modulo_contatos.sh
# ================================

echo "📌 Iniciando reinstalação do módulo de contatos..."

# Aliases
PHP="php83"
ARTISAN="artisan"

# Controller
echo "🚀 (1/6) Criando ContatoController..."
$ARTISAN make:controller ContatoController --force

cat > app/Http/Controllers/ContatoController.php <<'EOL'
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ContatoController extends Controller
{
    public function index()
    {
        $contatos = DB::table('contatos')->orderBy('nome')->get();
        return view('contato_list', compact('contatos'));
    }

    public function create()
    {
        return view('contato_form');
    }

    public function buscaCNPJ($cnpj)
    {
        $resposta = Http::get("https://receitaws.com.br/v1/cnpj/$cnpj");
        return response()->json($resposta->json());
    }

    public function buscaCEP($cep)
    {
        $resposta = Http::get("https://viacep.com.br/ws/$cep/json/");
        return response()->json($resposta->json());
    }
}
EOL

# Views
echo "🖼️ (2/6) Criando view: contato_form..."
mkdir -p resources/views
cat > resources/views/contato_form.blade.php <<'EOL'
@extends('layouts.app')
@section('title', 'Novo Contato')
@section('content')
<div class="container mt-4">
    <h3>Novo Contato</h3>
    <form>
        <div class="mb-3">
            <label>Nome</label><input class="form-control" />
        </div>
        <div class="mb-3">
            <label>CPF/CNPJ</label><input class="form-control" />
        </div>
        <!-- Mais campos aqui -->
    </form>
</div>
@endsection
EOL

echo "📋 (3/6) Criando view: contato_list..."
cat > resources/views/contato_list.blade.php <<'EOL'
@extends('layouts.app')
@section('title', 'Lista de Contatos')
@section('content')
<div class="container mt-4">
    <h3>Contatos</h3>
    <table class="table">
        <thead><tr><th>Nome</th><th>Documento</th></tr></thead>
        <tbody>
        @foreach($contatos as $c)
            <tr><td>{{ $c->nome }}</td><td>{{ $c->documento }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
EOL

# Layout base
echo "🧱 (4/6) Criando layout: layouts/app.blade.php..."
mkdir -p resources/views/layouts
cat > resources/views/layouts/app.blade.php <<'EOL'
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - ERP XTD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { padding-top: 56px; }</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top border-bottom shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">ERP XTD</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('contatos.index') }}">Contatos</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('financeiro.index') }}">Financeiro</a></li>
        </ul>
    </div>
</nav>
@yield('content')
</body>
</html>
EOL

# Rotas
echo "🌐 (5/6) Atualizando rotas web.php..."
cat > routes/web.php <<'EOL'
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FinanceiroController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/contatos', [ContatoController::class, 'index'])->name('contatos.index');
Route::get('/contatos/novo', [ContatoController::class, 'create'])->name('contatos.create');
Route::get('/contatos/cnpj/{cnpj}', [ContatoController::class, 'buscaCNPJ']);
Route::get('/contatos/cep/{cep}', [ContatoController::class, 'buscaCEP']);

Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro.index');
EOL

# Permissões
echo "🔐 (6/6) Corrigindo permissões..."
chown -R www:www storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "✅ Módulo de contatos reinstalado com sucesso!"
echo "Acesse: http://erp.xtd.com.br/contatos"
