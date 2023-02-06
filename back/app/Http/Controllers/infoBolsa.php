<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;

class infoBolsa extends Controller
{

public function insertarDatos()
{
    $fecha = new DateTime();
    
    $fechaInicial = new DateTime('2022-01-01 12:35:35');
    
    $empresas = 10;

    while ($fechaInicial <= $fecha) {

        // Recorre cada empresa
        for ($j = 0; $j < $empresas; $j++) {

            $ultimoValor = DB::table('valores')
                ->where('empresa_id', $j)
                ->orderBy('fecha', 'desc')
                ->first();

            $valor = 15;
            if ($ultimoValor) {
                $valor = $ultimoValor->valor;
            }
            $variacion = mt_rand(1, 20) / 100;

            $resto = $valor * $variacion;

            $SoB = mt_rand(1, 2);
            
            if($valor<0.3){
                $SoB = 1;
            }

            if ($SoB == 1) { //Subida
                $valor = $valor + $resto;
            } else if ($SoB == 2) { //Bajada
                $valor = $valor - $resto;
            }

            DB::table('valores')->insert([
                'empresa_id' => $j,
                'fecha' => $fechaInicial->format('Y-m-d H:i:s'),
                'valor' => $valor
            ]);
        }

        if ($fechaInicial == $fecha) {
            $fecha->add(new DateInterval('PT1M'));
        } else {
            $fechaInicial->add(new DateInterval('PT1M'));
        }
        sleep(60);
    }
}

}

