<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nome',
        'nome_social',
        'cpf',
        'email',
        'cep',
        'endereco',
        'rua',
        'bairro',
        'numero',
        'complemento',
        'tipo',
        'ativo',
        'profissao_principal',
        'profissoes_extras',
        'nivel',
        'estrela',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'ativo'             => 'boolean',
        'estrela'           => 'boolean',
        'tipo'              => 'integer',
        'nivel'             => 'integer',
    ];

    public function servicos(): HasMany
    {
        return $this->hasMany(Servico::class);
    }
}
