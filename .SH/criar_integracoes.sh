#!/bin/bash
# ================================
# Script: Etapa 4 - Integrações
# Data: 2025-06-09
# Função: Criar serviços de integração (ViaCEP, ReceitaWS)
# Execução: chmod +x && ./criar_integracoes.sh
# PHP: 8.3 via aaPanel
# ================================

PHP="/www/server/php/83/bin/php"
ARTISAN="$PHP artisan"

echo "📦 Criando diretório App/Services..."
mkdir -p app/Services

echo "🧠 Gerando serviço ApiService.php..."
cat > app/Services/ApiService.php <<'EOL'
<?php
// ================================
// Arquivo: ApiService.php
// Data: 2025-06-09
// Função: Serviço genérico de APIs HTTP
// Local: app/Services/
// ================================

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    public static function consultar($url)
    {
        try {
            $resposta = Http::get($url);
            return $resposta->json();
        } catch (\Exception $e) {
            Log::error("Erro ao consultar API: " . $e->getMessage());
            return ['erro' => true, 'mensagem' => 'Erro ao consultar API'];
        }
    }
}
EOL

echo "🔁 Atualizando ContatoController para usar ApiService..."
cat > app/Http/Controllers/ContatoController.php <<'EOL'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ApiService;

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
        $dados = ApiService::consultar("https://receitaws.com.br/v1/cnpj/$cnpj");
        return response()->json($dados);
    }

    public function buscaCEP($cep)
    {
        $dados = ApiService::consultar("https://viacep.com.br/ws/$cep/json/");
        return response()->json($dados);
    }
}
EOL

echo "🔐 Ajustando permissões..."
chown -R www:www app/Services
chmod -R 775 app/Services

echo "✅ Integrações prontas e ativas por padrão!"
