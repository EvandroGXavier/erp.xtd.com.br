@extends('layouts.app')
@section('title', 'financeiro list')
@section('content')
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contas a Receber</title>
</head>
<body>
    <h2>Contas a Receber</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Contato</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th>Status</th>
                <th>Meio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contas as $conta)
                <tr>
                    <td>{{ $conta->contato }}</td>
                    <td>{{ $conta->valor }}</td>
                    <td>{{ $conta->vencimento }}</td>
                    <td>{{ $conta->status }}</td>
                    <td>{{ $conta->meio_pagamento }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
@endsection
