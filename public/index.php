<?php
/**
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 12/06/2025
 * Função: Ponto de entrada da aplicação Laravel, inicializa o framework
 * Nome do Arquivo: index.php
 * Localização: /www/wwwroot/erp.xtd.com.br/public/index.php
 * 
 * Estrutura:
 *  1. Definição de LARAVEL_START (linha 1)
 *  2. Checagem de modo de manutenção (linhas 4-7)
 *  3. Registro do autoloader do Composer (linha 10)
 *  4. Bootstrap da aplicação (linha 13)
 *  5. Tratamento da requisição HTTP (linha 16)
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Definição de LARAVEL_START

// 2. Determine se a aplicação está em modo de manutenção...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// 3. Registro do autoloader do Composer
require __DIR__.'/../vendor/autoload.php';

// 4. Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// 5. Tratamento da requisição HTTP
$app->handleRequest(Request::capture());
