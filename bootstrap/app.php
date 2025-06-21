<?php
/**
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 12/06/2025
 * Função: Configurar e instanciar a aplicação Laravel, definindo rotas,
 *          middleware e tratamento de exceções
 * Nome do Arquivo: app.php
 * Localização: /www/wwwroot/erp.xtd.com.br/bootstrap/app.php
 * 
 * Estrutura:
 *  1. Importação de classes essenciais (linhas 1-3)
 *  2. Configuração da aplicação apontando para a pasta base (linha 5)
 *  3. Definição de roteamento:
 *     - Web (__DIR__.'/../routes/web.php')
 *     - Console (__DIR__.'/../routes/console.php')
 *     - Health ('/up')
 *     (linhas 6-10)
 *  4. Configuração de middleware (linhas 11-14)
 *  5. Configuração de tratamento de exceções (linhas 15-18)
 *  6. Criação e retorno da instância da aplicação (linha 19)
 */

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    // 2. Configuração da aplicação com basePath
    ->withRouting(
        web: __DIR__.'/../routes/web.php',    // 3a. Roteamento Web
        commands: __DIR__.'/../routes/console.php', // 3b. Roteamento Console
        health: '/up'                         // 3c. Rota de health check
    )
    // 4. Registro de middleware
    ->withMiddleware(function (Middleware $middleware): void {
        // Adicionar middleware global aqui
    })
    // 5. Registro de tratamento de exceções
    ->withExceptions(function (Exceptions $exceptions): void {
        // Configurar manipuladores de exceção aqui
    })
    // 6. Criação da instância da aplicação
    ->create();
