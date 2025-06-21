<?php
/**
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 09/06/2025
 * Função: Exibir tela inicial do ERP XTD
 * Nome do Arquivo: DashboardController.php
 * Localização: /www/wwwroot/erp.xtd.com.br/app/Http/Controllers/DashboardController.php
 * 
 * Estrutura:
 *  1. Namespace e imports (linhas 1-6)
 *  2. Definição da classe DashboardController (linha 8)
 *  3. Método index:
 *     - Retorna a view 'dashboard' (linhas 10-14)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // 3. Método index: retorna a view principal sem dados adicionais
    public function index()
    {
        return view('dashboard');
    }
}
