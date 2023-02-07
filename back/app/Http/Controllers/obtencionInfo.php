<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class obtencionInfo extends Controller
{  

    public function mostrarValores()
    {
        $query = "SELECT valores.* FROM valores JOIN ( SELECT empresa_id, MAX(fecha) AS fecha  FROM valores  GROUP BY empresa_id ) max_fecha ON valores.empresa_id = max_fecha.empresa_id AND valores.fecha = max_fecha.fecha";

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
        // $query = "SELECT * FROM valores WHERE empresa_id = '".$id."'"; 
        // $data = DB::select($query)->take(1000);
        
        // $data = $data->skip(10)->take(1000)->get();
        
        $data = DB::table('valores')
          ->where('empresa_id', $id)
          ->paginate(1000);

        return response()->json([
            'data' => $data
        ]);
    }


    // public function generador(){
    //     $id = DB::table('empresas')
    //     for ($j = 0; $j <= 9; $j++) {
    //         $fechaInicial = Carbon::parse('2022-01-01 12:35:35');
    //         $valor = 15;
    //             $fechaDB = DB::table('valores')
    //                 ->where('empresa_id', $j)
    //                 ->orderBy('fecha', 'desc')
    //                 ->first();
    //                 if($fechaDB != null){
    //                     $fechaInicial = $fechaDB->fecha;
    //                     $valor = $fechaDB->valor;
    //                 }
                    
    //         $fechaActual = Carbon::now();

    //         while ($fechaInicial <= $fechaActual) {
      
    //             $variacion = mt_rand(1, 10) / 100;

    //             $resto = $valor * $variacion;

    //             $SoB = mt_rand(1, 2);

    //             if ($valor < 0.3) {
    //                 $SoB = 1;
    //             }

    //             if ($SoB == 1) { //Subida
    //                 $valor = $valor + $resto;
    //             } else if ($SoB == 2) { //Bajada
    //                 $valor = $valor - $resto;
    //             }

    //             DB::table('valores')->insert([
    //                 'empresa_id' => $j,
    //                 'fecha' => $fechaInicial->toDateTimeString(),
    //                 'valor' => $valor
    //             ]);
    //         }
    //         if ($fechaInicial <= Carbon::now()->subWeek()) {
    //             $fechaInicial->addDay();
    //         } else {
    //             $fechaInicial->addMinute();
    //         }
    //     }
    //         return response()->json([
    //             'true' => true
    //         ]);
    // }
}