<?php

namespace App\Helpers;

use DateTime;
use Exception;

class Util{

    /**
         * Formata um valor numérico como moeda BRL.
         *
         * @param float $valor
         * @param bool $comSimbolo Se true, adiciona R$
         * @return string
     */
    public static function formataDinheiro(float $valor, bool $comSimbolo = true): string
    {
        $formatado = number_format($valor, 2, ',', '.');

        return $comSimbolo ? 'R$ ' . $formatado : $formatado;
    }

    /**
         * Formata uma data para o padrão brasileiro ou com outro separador.
         *
         * @param string $data       Data em formato válido (ex: '2025-09-12')
         * @param string $padrao     Separador desejado: '/' (default) ou '-'
         * @return string|null       Retorna a data formatada ou null se inválida
         *
         * Exemplo de uso:
         * Util::formataData('2025-09-12');       // retorna '12/09/2025'
         * Util::formataData('12/09/2025', '-');  // retorna '2025-09-12'
         * Util::formataData(null);               // retorna null
     */

    public static function formataData($data, $padrao='/')
    {

        if (!$data) {
            return null;
        }

        try {
            $date = new DateTime($data);
        } catch (Exception $e) {
            return null;
        }

        $formato = $padrao === '/' ? 'd/m/Y' : 'Y-m-d';

        return $date->format($formato);
    }

}



?>
