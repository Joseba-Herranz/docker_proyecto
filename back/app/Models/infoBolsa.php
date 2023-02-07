<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class infoBolsa extends Model
{
    use HasFactory;

    public function generador(){
       
        $id = DB::table('empresas')->count();
            
        for($j = 0; $j < $id; $j++) {
            $fechaInicial = Carbon::parse('2022-01-01 12:35:35');
            $valor = 15;
                $fechaDB = DB::table('valores')
                    ->where('empresa_id', $j)
                    ->orderBy('fecha', 'desc')
                    ->first();
                    if($fechaDB != null){
                        $fechaInicial = $fechaDB->fecha;
                        $valor = $fechaDB->valor;
                    }
                    
            $fechaActual = Carbon::now();
        
            while ($fechaInicial <= $fechaActual) {
                
                $variacion = mt_rand(1, 10) / 100;

                $resto = $valor * $variacion;

                $SoB = mt_rand(1, 2);

                if ($valor < 0.3) {
                    $SoB = 1;
                }

                if ($SoB == 1) { //Subida
                    $valor = $valor + $resto;
                } else if ($SoB == 2) { //Bajada
                    $valor = $valor - $resto;
                }

                DB::table('valores')->insert([
                    'empresa_id' => $j,
                    'fecha' => $fechaInicial,
                    'valor' => $valor,
                    'SoB' => $SoB
                ]);


                if ($fechaInicial <= Carbon::now()->subWeek()) {
                    $fechaInicial = Carbon::parse($fechaInicial)->addDay();
                } else if($fechaInicial <= Carbon::now()->subDay()){
                    $fechaInicial= Carbon::parse($fechaInicial)->addHour();
                } else{
                    $fechaInicial= Carbon::parse($fechaInicial)->addMinutes();
                }

            }   
        };
    }
}
