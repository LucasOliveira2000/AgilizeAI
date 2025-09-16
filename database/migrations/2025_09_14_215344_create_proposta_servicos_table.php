<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposta_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("servico_id")->constrained("servicos", "id")->onDelete('cascade');
            $table->foreignId("user_id")->constrained("users", "id")->onDelete("cascade");
            $table->text('resumo');
            $table->decimal("valor_contra_proposta", 10, 2)->nullable();
            $table->boolean("ativo")->default(true);
            $table->tinyInteger("status")->default(1)->comment("1 - Enviada, 2 - Em negociação, 3 - Aceita, 4 - Concluída, 5 - Recusada");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposta_servicos');
    }
};
