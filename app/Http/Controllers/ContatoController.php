<?php
/**
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 12/06/2025
 * Função: Controller para gerenciar cadastros de contatos
 * Nome do Arquivo: ContatoController.php
 * Localização: /www/wwwroot/erp.xtd.com.br/app/Http/Controllers/ContatoController.php
 * 
 * Estrutura:
 *  1. Namespace e imports (linhas 1-4)
 *  2. Classe ContatoController extende Controller (linha 6)
 *  3. Método index():
 *     - Busca lista de contatos na tabela 'contatos' ordenada por nome (linha 9)
 *     - Retorna view 'contato_list' com variável $contatos (linha 10)
 *  4. Método create(): Retorna view 'contato_form' (linha 14)
 *  5. Método buscaCNPJ($cnpj):
 *     - Faz requisição HTTP à API ReceitaWS (linha 17)
 *     - Retorna JSON da resposta (linha 18)
 *  6. Método buscaCEP($cep):
 *     - Faz requisição HTTP à API ViaCEP (linha 22)
 *     - Retorna JSON da resposta (linha 23)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ContatoController extends Controller
{
    // 3. Exibe listagem de contatos
    public function index()
    {
        $contatos = DB::table('contatos')->orderBy('nome')->get();
        return view('contato_list', compact('contatos'));
    }

    // 4. Exibe formulário de criação de contato
    public function create()
    {
        return view('contato_form');
    }

    // 5. Busca informações de CNPJ via API externa
    public function buscaCNPJ($cnpj)
    {
        $resposta = Http::get("https://receitaws.com.br/v1/cnpj/$cnpj");
        return response()->json($resposta->json());
    }

    // 6. Busca informações de CEP via API externa
    public function buscaCEP($cep)
    {
        $resposta = Http::get("https://viacep.com.br/ws/$cep/json/");
        return response()->json($resposta->json());
    }
}
