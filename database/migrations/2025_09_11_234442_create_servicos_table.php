<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('titulo', 100);
            $table->string('tags_padroes')->nullable();
            $table->longText('resumo');
            $table->longText('profissoes');
            $table->integer('qtd_vagas');
            $table->decimal('valor_minimo', 10, 2)->nullable();
            $table->decimal('valor_maximo', 10 ,2)->nullable();
            $table->date('data_prevista_entrega')->nullable();
            $table->date('data_maxima_entrega')->nullable();
            $table->integer('status')->default(1)->comment("1 - Anunciada, 2 - Iniciada, 3 - Fase de Pagamento, 4 - Concluída");
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
