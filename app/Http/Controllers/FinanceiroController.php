<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function index()
    {
        $contas = DB::table('financeiros')
            ->join('contatos', 'contatos.id', '=', 'financeiros.contato_id')
            ->select('financeiros.*', 'contatos.nome as contato')
            ->orderBy('vencimento', 'asc')
            ->get();
        return view('financeiro_list', compact('contas'));
    }

    public function create()
    {
        $contatos = DB::table('contatos')->orderBy('nome')->get();
        return view('financeiro_form', compact('contatos'));
    }
}
