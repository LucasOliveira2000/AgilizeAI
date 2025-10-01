<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\Models\PropostaServico;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropostaServicoController extends Controller
{

    public function myProposals()
    {
        $myProposals = PropostaServico::with('servico')->where("user_id", Auth::id())->paginate(10)->through(function($proposal){
            return [
                "servico"   => [
                    "user"                  => $proposal->servico->user->nome,
                    "titulo"                => $proposal->servico->titulo,
                    "resumo"                => $proposal->servico->resumo,
                    "valor_minimo"          => Util::formataDinheiro($proposal->servico->valor_minimo),
                    "valor_maximo"          => Util::formataDinheiro($proposal->servico->valor_maximo),
                    "data_prevista_entrega" => Util::formataData($proposal->servico->data_prevista_entrega),
                    "status"                => $proposal->servico->status
                ],
                "proposta"  => [
                    "resumo"                => $proposal->resumo,
                    "valor_contra_proposta" => $proposal->valor_contra_proposta,
                    "ativo"                 => $proposal->ativo,
                    "status"                => $proposal->status
                ]
            ];
        });

        return response()->json([
            "sucess"    => true,
            "data"      => [
                "minhasPropostas" => $myProposals
            ]
        ]);
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
                'sucess'    => false,
                'message'   => 'Você já se candidatou para este serviço!'
            ], 422);
        }

        PropostaServico::create([
            'user_id' => Auth::id(),
            'servico_id' => $request->servico_id,
            'resumo' => $request->resumo,
            'valor_contra_proposta' => $request->valor_contra_proposta,
            'status' => 1,
            'ativo' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proposta enviada com sucesso!'
        ], 201);
    }



    public function show($id)
    {
        try{
            $propostaServico = PropostaServico::where([
                'id'        => $id,
                'user_id'   => Auth::id()
            ])->with('servico')->map(function($proposta) {
                return [
                    "servico"   => [
                        "user"                  => $proposta->servico->user->nome,
                        "titulo"                => $proposta->servico->titulo,
                        "resumo"                => $proposta->servico->resumo,
                        "valor_minimo"          => Util::formataDinheiro($proposta->servico->valor_minimo),
                        "valor_maximo"          => Util::formataDinheiro($proposta->servico->valor_maximo),
                        "data_prevista_entrega" => Util::formataData($proposta->servico->data_prevista_entrega),
                        "status"                => $proposta->servico->status
                    ],
                    "proposta"  => [
                        "resumo"                => $proposta->resumo,
                        "valor_contra_proposta" => Util::formataDinheiro($proposta->valor_contra_proposta),
                        "ativo"                 => $proposta->ativo,
                        "status"                => $proposta->status
                    ]
                ];
            })->firstOrFail();
        }catch(ModelNotFoundException $e){
            return response()->json([
                "success" => false,
                "message" => "Proposta não encontrada"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => [
                "proposta" => $propostaServico
            ]
        ]);
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
