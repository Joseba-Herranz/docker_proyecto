<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use Carbon\Carbon;


class obtencionInfo extends Controller
{  

    public function mostrarValores()
    {   
        $query = "SELECT * FROM valores  WHERE fecha=(SELECT MAX(fecha) AS 'Ultima fecha' FROM `valores`)";
        $data = DB::select($query);
        
        
        return response()->json([
            'data' => $data
        ]);

        
    }

    public function grafico(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->input('id');
        $query = "SELECT * FROM valores WHERE empresa_id = '".$id."'"; 
        $data = DB::select($query);
        
        
        return response()->json([
            'data' => $data
        ]);
    }


    public function generador(){
        $fechaInicial = Carbon::parse('2022-01-01 12:35:35');
        $resultado = DB::table('valores')->first();

        if($resultado){
            $fechaDB = DB::table('valores')
            // ->where('empresa_id', $j)
            ->orderBy('fecha', 'desc')
            ->first();
            if($fechaInicial->lt($fechaDB->fecha)){
                $fechaInicial = Carbon::parse($fechaDB->fecha);
            }
        }

        $fechaFinal = Carbon::now()->subWeek();
        $fechaActual = Carbon::now();

        $semana = 7;
        $var = 0;
 
        $empresas = 9;

        while ($fechaInicial <= $fechaFinal) {

            // Recorre cada empresa
            for ($j = 0; $j <= $empresas; $j++) {
        
                $ultimoValor = DB::table('valores')
                    ->where('empresa_id', $j)
                    ->orderBy('fecha', 'desc')
                    ->first();
        
                $valor = 15;
                if ($ultimoValor) {
                    $valor = $ultimoValor->valor;
                }
                $variacion = mt_rand(1, 10) / 100;
        
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
                    'fecha' => $fechaInicial->toDateTimeString(),
                    'valor' => $valor
                ]);
            }
            
            $fechaInicial->addDay();
            
        }

        while($var <= $semana){

            for ($j = 0; $j <= $empresas; $j++) {
        
                $ultimoValor = DB::table('valores')
                    ->where('empresa_id', $j)
                    ->orderBy('fecha', 'desc')
                    ->first();
        
                $valor = 15;
                if ($ultimoValor) {
                    $valor = $ultimoValor->valor;
                }
                $variacion = mt_rand(1, 10) / 100;
        
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
                    'fecha' => $fechaInicial->toDateTimeString(),
                    'valor' => $valor
                ]);
            }
        
            $fechaInicial->addMinute();
        }
        
            for ($j = 0; $j <= $empresas; $j++) {
    
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
                    'fecha' => $fechaActual->toDateTimeString(),
                    'valor' => $valor
                ]);
            }

            return response()->json([
                'true' => true
            ]);
    }
}