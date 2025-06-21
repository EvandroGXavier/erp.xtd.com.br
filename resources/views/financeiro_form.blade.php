@extends('layouts.app')
@section('title', 'financeiro form')
@section('content')
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Conta a Receber</title>
</head>
<body>
    <h2>Nova Conta a Receber</h2>
    <form method="post" action="#">
        <label>Contato:</label>
        <select name="contato_id">
            @foreach($contatos as $contato)
                <option value="{{ $contato->id }}">{{ $contato->nome }}</option>
            @endforeach
        </select><br><br>
        <label>Valor:</label>
        <input type="text" name="valor"><br><br>
        <label>Vencimento:</label>
        <input type="date" name="vencimento"><br><br>
        <label>Status:</label>
        <input type="text" name="status"><br><br>
        <label>Meio de Pagamento:</label>
        <input type="text" name="meio_pagamento"><br><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
@endsection
