#!/bin/bash
# ================================
# Script: Etapa 3 - Módulo Financeiro
# Data: 2025-06-09
# Função: Criar formulário e listagem de contas a receber
# Execução: chmod +x && ./criar_modulo_financeiro.sh
# PHP: 8.3 via aaPanel
# ================================

PHP="/www/server/php/83/bin/php"
ARTISAN="$PHP artisan"

echo "🚀 Verificando se FinanceiroController já existe..."
if [ -f "app/Http/Controllers/FinanceiroController.php" ]; then
    echo "⚠️  FinanceiroController já existe. Pulando criação."
else
    $ARTISAN make:controller FinanceiroController
fi

echo "🧠 Inserindo código no controller..."
cat > app/Http/Controllers/FinanceiroController.php <<'EOL'
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function index()
    {
        $contas = DB::table('financeiros')
            ->join('contatos', 'contatos.id', '=', 'financeiros.contato_id')
            ->select('financeiros.*', 'contatos.nome as contato')
            ->orderBy('vencimento', 'asc')
            ->get();
        return view('financeiro_list', compact('contas'));
    }

    public function create()
    {
        $contatos = DB::table('contatos')->orderBy('nome')->get();
        return view('financeiro_form', compact('contatos'));
    }
}
EOL

echo "📄 Criando formulário financeiro_form..."
mkdir -p resources/views
cat > resources/views/financeiro_form.blade.php <<'EOL'
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Conta a Receber</title>
</head>
<body>
    <h2>Nova Conta a Receber</h2>
    <form method="post" action="#">
        <label>Contato:</label>
        <select name="contato_id">
            @foreach($contatos as $contato)
                <option value="{{ $contato->id }}">{{ $contato->nome }}</option>
            @endforeach
        </select><br><br>
        <label>Valor:</label>
        <input type="text" name="valor"><br><br>
        <label>Vencimento:</label>
        <input type="date" name="vencimento"><br><br>
        <label>Status:</label>
        <input type="text" name="status"><br><br>
        <label>Meio de Pagamento:</label>
        <input type="text" name="meio_pagamento"><br><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
EOL

echo "📋 Criando listagem financeiro_list..."
cat > resources/views/financeiro_list.blade.php <<'EOL'
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contas a Receber</title>
</head>
<body>
    <h2>Contas a Receber</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Contato</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th>Status</th>
                <th>Meio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contas as $conta)
                <tr>
                    <td>{{ $conta->contato }}</td>
                    <td>{{ $conta->valor }}</td>
                    <td>{{ $conta->vencimento }}</td>
                    <td>{{ $conta->status }}</td>
                    <td>{{ $conta->meio_pagamento }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
EOL

echo "🌐 Atualizando rotas..."
cat >> routes/web.php <<'EOL'

// ================================
// Rota: Módulo Financeiro
// Data: 2025-06-09
// Função: Rotas de contas a receber
// ================================

use App\Http\Controllers\FinanceiroController;
Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro.index');
Route::get('/financeiro/novo', [FinanceiroController::class, 'create'])->name('financeiro.create');
EOL

echo "🔐 Ajustando permissões..."
chown -R www:www storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "✅ Módulo financeiro criado com sucesso!"
echo "Acesse: http://erp.xtd.com.br/financeiro"
