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
