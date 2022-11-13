<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UbicacionPaquete;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UbicacionPaqueteController extends Controller
{
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/'); 
        $registro=new UbicacionPaquete();
        $registro->idingreso=$request->idingreso;
        $registro->idlocal=$request->idlocal;
        $registro->anaquel=$request->anaquel;
        $registro->paquete=$request->paquete;
        $registro->idusuario=$request->idusuario;
        $registro->condicion='1';
        $registro->save();
    }
}
