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
