<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Resources\modificador;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;
use App\Models\infoBolsa;


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

        // $data = DB::table('valores')
        //     ->where('empresa_id', $id)
        //   ->paginate(1000);
        $query = "SELECT * FROM valores WHERE empresa_id = $id AND HOUR(fecha) > 9 AND HOUR(fecha) < 17 AND (id % 2)";
        $data = DB::select($query);
        // $data = DB::table('valores')->where('empresa', $id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function creacion()
    {
        $model = new infoBolsa();
        $model->generador();

        $data = array();
        $id = DB::table('empresas')->count();
            
        for($x = 0; $x < $id; $x++) {
        
            $data[$x] = DB::table('valores')->where('empresa_id', $x);
        
        }
        // return modificador::collection($datos);
        return response()->json([
            'data' => $data
        ]);
    }
}