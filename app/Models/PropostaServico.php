<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class PropostaServico extends Model
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'user_id',
        'servico_id',
        'resumo',
        'valor_contra_proposta',
        'status',
        'ativo'
    ];

    protected $casts = [
        'valor_contra_proposta'  => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }
}
