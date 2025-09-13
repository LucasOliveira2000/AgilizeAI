<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Servico extends Model
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'tags_padroes',
        'resumo',
        'profissoes',
        'qtd_vagas',
        'valor_minimo',
        'valor_maximo',
        'data_prevista_entrega',
        'data_maxima_entrega',
        'status',
        'ativo'
    ];

    protected $casts = [
        'data_prevista_entrega' => 'date',
        'data_maxima_entrega'   => 'date',
        'ativo'                 => 'boolean',
        'valor_minimo'          => 'decimal:2',
        'valor_maximo'          => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
