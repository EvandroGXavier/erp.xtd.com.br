{{--
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 12/06/2025
 * Função: View da página inicial estendendo o layout com menu
 * Nome do Arquivo: dashboard.blade.php
 * Localização: /www/wwwroot/erp.xtd.com.br/resources/views/dashboard.blade.php
 * 
 * Estrutura:
 *  1. Extensão do layout padrão (layouts.app)
 *  2. Seção content: container central com mensagem de boas-vindas
 --}}

@extends('layouts.app')

@section('content')
<div class="p-6 text-center">
    <h1 class="text-2xl font-bold">Bem-vindo ao ERP XTD</h1>
    <p>Estrutura inicial carregada com sucesso.</p>
</div>
@endsection
