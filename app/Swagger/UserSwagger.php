<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="AgilizeAi API",
 *     description="Documentação da API do AgilizeAi",
 *     @OA\Contact(email="agilizeai@agilizeai.com.br")
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor da API"
 * )
 *
 * @OA\Tag(name="Usuários", description="Operações relacionadas a usuários")
 */

class UserSwagger
{
    /**
     * @OA\Get(
     *     path="/api/user/profile",
     *     tags={"Usuários"},
     *     summary="Retorna o perfil do usuário autenticado",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Perfil retornado com sucesso"),
     *     @OA\Response(response=401, description="Não autorizado")
     * )
     *
     * @OA\Post(
     *     path="/api/user/register",
     *     tags={"Usuários"},
     *     summary="Registra um novo usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nome", type="string", example="Lucas Oliveira"),
     *             @OA\Property(property="cpf", type="string", example="12345678901"),
     *             @OA\Property(property="email", type="string", example="lucas@example.com"),
     *             @OA\Property(property="password", type="string", example="Senha123!"),
     *             @OA\Property(property="password_confirmation", type="string", example="Senha123!")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuário registrado com sucesso"),
     *     @OA\Response(response=422, description="Validação falhou")
     * )
     *
     * @OA\Post(
     *     path="/api/user/login",
     *     tags={"Usuários"},
     *     summary="Login do usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", example="lucas@example.com"),
     *             @OA\Property(property="password", type="string", example="SenhaForte@123!")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login realizado com sucesso"),
     *     @OA\Response(response=401, description="Credenciais inválidas")
     * )
     *
     * @OA\Post(
     *     path="/api/user/logout",
     *     tags={"Usuários"},
     *     summary="Logout do usuário",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Logout realizado com sucesso"),
     *     @OA\Response(response=401, description="Não autorizado")
     * )
     */
    public function annotations()
    {
        // Este método não executa nada, é só para agrupar as anotações.
    }
}
