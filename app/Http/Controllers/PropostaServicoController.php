<?php

namespace App\Http\Controllers;

use App\Models\PropostaServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropostaServicoController extends Controller
{

    public function index()
    {

    }

    public function register(Request $request)
    {
        $request->validate([
            'servico_id'            => 'required|exists:servicos,id',
            'resumo'                => 'required|string|max:1000',
            'valor_contra_proposta' => 'nullable|numeric',
        ], [
            'servico_id.required'           => 'O campo serviço é obrigatório.',
            'servico_id.exists'             => 'O serviço selecionado não existe.',
            'resumo.required'               => 'O campo resumo é obrigatório.',
            'resumo.string'                 => 'O resumo deve ser um texto válido.',
            'resumo.max'                    => 'O resumo não pode passar de 1000 caracteres.',
            'valor_contra_proposta.numeric' => 'O valor da contra proposta deve ser numérico.',
        ]);

        $jaExiste = PropostaServico::where('servico_id', $request->servico_id)
        ->where('user_id', Auth::id())
        ->exists();

        if ($jaExiste) {
            return response()->json([
                'message' => 'Você já se candidatou a este serviço!'
            ], 422);
        }

        $propostaServico = PropostaServico::create([
            'user_id' => Auth::id(),
            'servico_id' => $request->servico_id,
            'resumo' => $request->resumo,
            'valor_contra_proposta' => $request->valor_contra_proposta,
            'status' => 1,
            'ativo' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proposta enviada com sucesso!',
            'data' => $propostaServico
        ], 201);
    }

    public function show(PropostaServico $propostaServico)
    {

    }

    public function edit(PropostaServico $propostaServico)
    {

    }

    public function update(Request $request, PropostaServico $propostaServico)
    {

    }

    public function destroy(PropostaServico $propostaServico)
    {

    }
}
