<?php
/**
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 12/06/2025
 * Função: Definir as rotas principais da aplicação para Dashboard,
 *          Contatos e Financeiro
 * Nome do Arquivo: web.php
 * Localização: /www/wwwroot/erp.xtd.com.br/routes/web.php
 * 
 * Estrutura:
 *  1. Importação de Facades e Controllers (linhas 1-4)
 *  2. Rota Dashboard (GET /) → DashboardController@index (linha 6)
 *  3. Rotas de Contatos:
 *     - GET /contatos → ContatoController@index (linha 8)
 *     - GET /contatos/novo → ContatoController@create (linha 9)
 *     - GET /contatos/cnpj/{cnpj} → ContatoController@buscaCNPJ (linha 10)
 *     - GET /contatos/cep/{cep} → ContatoController@buscaCEP (linha 11)
 *  4. Rota Financeiro (GET /financeiro) → FinanceiroController@index (linha 13)
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FinanceiroController;

// 2. Rota Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 3. Rotas de Contatos
Route::get('/contatos', [ContatoController::class, 'index'])->name('contatos.index');
Route::get('/contatos/novo', [ContatoController::class, 'create'])->name('contatos.create');
Route::get('/contatos/cnpj/{cnpj}', [ContatoController::class, 'buscaCNPJ']);
Route::get('/contatos/cep/{cep}', [ContatoController::class, 'buscaCEP']);

Route::get('/contatos/{contato}/edit', [ContatoController::class, 'edit'])->name('contatos.edit');
Route::delete('/contatos/{contato}', [ContatoController::class, 'destroy'])->name('contatos.destroy');


// 4. Rota Financeiro
Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro.index');
