{{--
 * ---------------------------------------------------------------
 * Índice do Arquivo
 * ---------------------------------------------------------------
 * Data: 12/06/2025
 * Função: View do formulário de criação de novo contato
 * Nome do Arquivo: contato_form.blade.php
 * Localização: /www/wwwroot/erp.xtd.com.br/resources/views/contato_form.blade.php
 * 
 * Estrutura:
 *  1. Extensão do layout padrão (layouts.app)
 *  2. Definição de título da página (section title)
 *  3. Seção content:
 *    - Container com título e formulário de campos (linhas 7-16)
 *    - Campos iniciais: Nome e CPF/CNPJ (campo mapeado como 'cpf_cnpj' no banco)
 *    - Comentário para inclusão de campos adicionais
 * 
 * Observações:
 *  - Campo 'cpf_cnpj' deve corresponder à coluna 'cpf_cnpj' da tabela 'contatos'.
 *  - Inserir @csrf para proteção CSRF.
 --}}

@extends('layouts.app')

@section('title', 'Novo Contato')

@section('content')
<div class="container mt-4">
    <h3>Novo Contato</h3>
    <form method="POST" action="{{ route('contatos.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" required />
        </div>
        <div class="mb-3">
            <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
            <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control" required />
        </div>
        <!-- Mais campos aqui -->
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
