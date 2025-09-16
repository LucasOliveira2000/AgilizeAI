<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\Models\PropostaServico;
use App\Models\Servico;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicoController extends Controller
{

    public function index()
    {
        $servicos = Servico::with('user')->paginate(10)->through(function($servico) {
            return [
                'id'                    => $servico->id,
                'titulo'                => $servico->titulo,
                'tags_padroes'          => $servico->tags_padroes,
                'resumo'                => $servico->resumo,
                'profissoes'            => $servico->profissoes,
                'qtd_vagas'             => $servico->qtd_vagas,
                'valor_minimo'          => Util::formataDinheiro($servico->valor_minimo),
                'valor_maximo'          => Util::formataDinheiro($servico->valor_maximo),
                'data_prevista_entrega' => Util::formataData($servico->data_prevista_entrega),
                'data_maxima_entrega'   => Util::formataData($servico->data_maxima_entrega),
                'status'                => $servico->status,
                'ativo'                 => $servico->ativo,
                'data_criado'           => Util::formataData($servico->created_at),
                'user'  => [
                    'id'    => $servico->user->id,
                    'nome'  => $servico->user->nome
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $servicos
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'titulo'                => 'required|string|max:100',
            'tags_padroes'          => 'nullable|string',
            'resumo'                => 'required|string',
            'profissoes'            => 'required|string',
            'qtd_vagas'             => 'required|integer|min:1',
            'valor_minimo'          => 'required|numeric|min:0',
            'valor_maximo'          => 'required|numeric|min:0|gte:valor_minimo',
            'data_prevista_entrega' => 'nullable|date',
            'data_maxima_entrega'   => 'nullable|date|after_or_equal:data_prevista_entrega',
            'status'                => 'required|integer',
            'ativo'                 => 'required|boolean'
        ], [
            'titulo.required'                       => 'O título é obrigatório.',
            'resumo.required'                       => 'O resumo é obrigatório.',
            'profissoes.required'                   => 'As profissões são obrigatórias.',
            'qtd_vagas.required'                    => 'A quantidade de vagas é obrigatória.',
            'valor_minimo.required'                 => 'O valor mínimo é obrigatório.',
            'valor_maximo.required'                 => 'O valor máximo é obrigatório e deve ser maior ou igual ao mínimo.',
            'data_maxima_entrega.after_or_equal'    => 'A data máxima deve ser igual ou posterior à data prevista.',
            'ativo.required'                        => 'O campo ativo é obrigatório.'
        ]);

        $servico = Servico::create([
            'titulo'                => $request->titulo,
            'user_id'               => Auth::id(),
            'tags_padroes'          => $request->tags_padroes,
            'resumo'                => $request->resumo,
            'profissoes'            => $request->profissoes,
            'qtd_vagas'             => $request->qtd_vagas,
            'valor_minimo'          => $request->valor_minimo,
            'valor_maximo'          => $request->valor_maximo,
            'data_prevista_entrega' => $request->data_prevista_entrega,
            'data_maxima_entrega'   => $request->data_maxima_entrega,
            'status'                => $request->status,
            'ativo'                 => $request->ativo,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Serviço registrado com sucesso!',
            'data' => $servico
        ], 201);
    }

    public function show($id)
    {
        try{
            $servico = Servico::FindOrFail($id);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'sucess'    => false,
                'message'   => "Não conseguimos identificar esse serviço!"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id'                    => $servico->id,
                'titulo'                => $servico->titulo,
                'tags_padroes'          => $servico->tags_padroes,
                'resumo'                => $servico->resumo,
                'profissoes'            => $servico->profissoes,
                'qtd_vagas'             => $servico->qtd_vagas,
                'valor_minimo'          => Util::formataDinheiro($servico->valor_minimo),
                'valor_maximo'          => Util::formataDinheiro($servico->valor_maximo),
                'data_prevista_entrega' => $servico->data_prevista_entrega,
                'data_maxima_entrega'   => $servico->data_maxima_entrega,
                'status'                => $servico->status,
                'ativo'                 => $servico->ativo,
                'user'                  => [
                    "id"    => $servico->user->id,
                    "nome"  => $servico->user->nome,
                    "email" => $servico->user->email
                ],
            ]
        ]);

    }

    public function myServices()
    {
        $user = Auth::user();
        $servicos = Servico::where('user_id', $user->id)->paginate(10)->through(function($servico){

            return [
                'id'                    => $servico->id,
                'titulo'                => $servico->titulo,
                'tags_padroes'          => explode('/', $servico->tags_padroes),
                'profissoes'            => explode('/', $servico->profissoes),
                'resumo'                => $servico->resumo,
                'qtd_vagas'             => $servico->qtd_vagas,
                'valor_minimo'          => Util::formataDinheiro($servico->valor_minimo),
                'valor_maximo'          => Util::formataDinheiro($servico->valor_maximo),
                'data_prevista_entrega' => Util::formataData($servico->data_prevista_entrega),
                'data_maxima_entrega'   => Util::formataData($servico->data_maxima_entrega),
                'status'                => $servico->status,
            ];
        });

        return response()->json([
            'success'   => true,
            'data'  => $servicos
        ]);
    }

    public function proposalService($servico_id)
    {
        try {
            $servico = Servico::where('user_id', Auth::id())->where('id', $servico_id)->firstOrFail();
        }catch(ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Serviço não encontrado ou não pertence a você.'
            ], 404);
        }

        $propostas_servico = PropostaServico::where('servico_id', $servico->id)->orderBy("id", "DESC")
            ->paginate(10)->through(function($proposta){
                return [
                    'resumo'                    => $proposta->resumo,
                    'valor_contra_proposta'     => Util::formataDinheiro($proposta->valor_contra_proposta),
                    'status'                    => $proposta->status,
                    'data_enviada'              => Util::formataData($proposta->created_at),
                    'ativo'                     => $proposta->ativo,
                    "user"                      => [
                        "nome"                      => $proposta->user->nome,
                        "email"                     => $proposta->user->email,
                        "nivel"                     => $proposta->user->nivel,
                        "estrela"                   => $proposta->user->estrela,
                        "profissao_principal"       => $proposta->user->profissao_principal,
                        "profissoes_extras"         => $proposta->user->profissoes_extras
                    ]
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $propostas_servico
        ]);
    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
