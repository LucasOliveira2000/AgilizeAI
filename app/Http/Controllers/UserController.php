<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            "success" => true,
            "user" => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome'                => 'required|min:4|max:100',
            'nome_social'         => 'nullable|string|min:4|max:100',
            'cpf'                 => 'required|string|size:11|unique:users,cpf',
            'email'               => 'required|email|unique:users,email',
            'cep'                 => 'required|string|max:20',
            'endereco'            => 'required|string|max:150',
            'rua'                 => 'required|string|max:150',
            'bairro'              => 'required|string|max:100',
            'numero'              => 'nullable|string|max:20',
            'complemento'         => 'nullable|string|max:60',
            'tipo'                => 'required|in:1,2',
            'profissao_principal' => 'nullable|string|max:100',
            'profissoes_extras'   => 'nullable|string|max:255',
            'password'            => ['required','confirmed',Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ], [
            'nome.required'                     => 'O campo nome é obrigatório.',
            'nome.min'                          => 'O nome deve ter no mínimo 4 caracteres.',
            'nome.max'                          => 'O nome deve ter no máximo 100 caracteres.',
            'nome_social.max'                   => 'O nome social deve ter no máximo 100 caracteres.',
            'nome_social.min'                   => 'O nome social deve ter no mínimo 4 caracteres.',
            'cpf.required'                      => 'O CPF é obrigatório.',
            'cpf.size'                          => 'O CPF deve ter 11 caracteres.',
            'cpf.unique'                        => 'Este CPF já está cadastrado.',
            'email.required'                    => 'O e-mail é obrigatório.',
            'email.email'                       => 'O e-mail deve ser válido.',
            'email.unique'                      => 'Este e-mail já está cadastrado.',
            'cep.required'                      => 'O CEP é obrigatório.',
            'cep.max'                           => 'O CEP deve ter no máximo 20 caracteres.',
            'endereco.required'                 => 'O endereço é obrigatório.',
            'endereco.max'                      => 'O endereço deve ter no máximo 150 caracteres.',
            'rua.required'                      => 'A rua é obrigatória.',
            'rua.max'                           => 'A rua deve ter no máximo 150 caracteres.',
            'bairro.required'                   => 'O bairro é obrigatório.',
            'bairro.max'                        => 'O bairro deve ter no máximo 100 caracteres.',
            'numero.max'                        => 'O número deve ter no máximo 20 caracteres.',
            'complemento.max'                   => 'O complemento deve ter no máximo 60 caracteres.',
            'tipo.required'                     => 'O tipo é obrigatório.',
            'tipo.in'                           => 'O tipo deve ser 1 (Cliente) ou 2 (Profissional).',
            'ativo.boolean'                     => 'O campo ativo deve ser verdadeiro ou falso.',
            'profissao_principal.max'           => 'A profissão principal deve ter no máximo 100 caracteres.',
            'profissoes_extras.max'             => 'As profissões extras devem ter no máximo 255 caracteres.',
            'password.required'                 => 'A senha é obrigatória.',
            'password.confirmed'                => 'A confirmação da senha não coincide.',
            'password.min'                      => 'A senha deve ter no mínimo 8 caracteres.',
            'password.mixedCase'                => 'A senha deve conter letras maiúsculas e minúsculas.',
            'password.numbers'                  => 'A senha deve conter ao menos um número.',
            'password.symbols'                  => 'A senha deve conter ao menos um símbolo.',
            'password.uncompromised'            => 'A senha apareceu em vazamentos de segurança. Escolha outra.'
        ]);

        $user = User::create([
            'nome'                => $request->nome,
            'nome_social'         => $request->nome_social,
            'cpf'                 => $request->cpf,
            'email'               => $request->email,
            'cep'                 => $request->cep,
            'endereco'            => $request->endereco,
            'rua'                 => $request->rua,
            'bairro'              => $request->bairro,
            'numero'              => $request->numero,
            'complemento'         => $request->complemento,
            'tipo'                => $request->tipo,
            'profissao_principal' => $request->profissao_principal,
            'profissoes_extras'   => $request->profissoes_extras,
            'password'            => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            "sucess"    => true,
            "user"      => $user,
            "token"     => $token,
            "message"   => "Seja bem vindo ".$user->nome
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'         => 'required|email',
            'password'      => 'required'
        ], [
            'email.required'    => 'O e-mail é obrigatório.',
            'email.email'       => 'O e-mail deve ser válido.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // if ($user->tokens()->count() > 0) {

            //     return response()->json([
            //         "success"   => false,
            //         "user"      => $user,
            //         "message"   => "Você já está logado " . ($user->nome_social ?? $user->nome)
            //     ], 403);
            // }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                "success"   => true,
                "user"      => $user,
                "token"     => $token,
                "message"   => "Seja bem-vindo " . ($user->nome_social ?? $user->nome)
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Email ou senha incorretos"
        ], 401);
    }


    public function edit(User $user)
    {

    }

    public function logout(Request $request)
    {
        if ($request->user()) {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout realizado com sucesso.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao se deslogar'
        ], 401);
    }

    public function delete(User $user)
    {

    }
}
