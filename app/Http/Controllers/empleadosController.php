<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\areas;
use App\Models\empleado_rol;
use App\Models\empleado;
use App\Models\roles;

class empleadosController extends Controller
{
    public function listEmpleado(Request $request){

         $xhr_response = Array("code" => 404,"status"=>"", "data" =>[] , "message" => "");

     $empleados = empleado::select(['empleado.id','empleado.nombre as empleado','empleado.email','empleado.sexo','areas.nombre','empleado.boletin'])
                                        ->join('areas', 'areas.id', '=', 'empleado.area_id')
                                        ->orderByDesc('empleado.nombre')
                                        ->get();
                      
         
                                        return view('empleados.list', [
                                            'data' => $empleados
                                        ]);
    }

    public function nuevoEmpleado(Request $request){

        $xhr_response = Array("code" => 404,"status"=>"", "data" =>[] , "message" => "");

                             $empleados = areas::select(['areas.*'])
                                       ->orderByDesc('areas.nombre')
                                       ->get();
                            $roles = roles::select(['roles.*'])
                            ->orderByDesc('roles.nombre')
                            ->get();
                                       
                     
        
                                       return view('empleados.crear', [
                                           'data' => $empleados,
                                           'roles' => $roles
                                       ]);
   }
    
    public function crearEmpleado(Request $request){

        $xhr_response = Array("code" => 404,"status"=>"", "data" =>[] , "message" => "");

if(isset($request->boletin)){
$boletin=1;
} else{
    $boletin=0;
}
if($request->name != "" && $request->email != "" && $request->gender != "" && $request->area != "" && $request->description != "" && $request->roles != ""){
        $guardarEmpleado = new empleado();
        $guardarEmpleado->nombre = $request->name;
        $guardarEmpleado->email = $request->email;
        $guardarEmpleado->sexo = $request->gender;
        $guardarEmpleado->area_id = $request->area;
        $guardarEmpleado->boletin = $boletin;
        $guardarEmpleado->descripcion = $request->description;
        $guardarEmpleado->idRol = $request->roles;

        if($guardarEmpleado->save()){

            $xhr_response = 200; 


        }

    } else{

        $xhr_response = 401; 

    }
        return $xhr_response;          
        
   }

   public function editEmpleado($id){


     $xhr_response = Array("code" => 404,"status"=>"", "data" =>[] , "message" => "");

        $empleados = empleado::select(['empleado.id','empleado.nombre as empleado','empleado.email','empleado.sexo','areas.nombre','empleado.boletin'])
                                        ->join('areas', 'areas.id', '=', 'empleado.area_id')
                                        ->where('empleado.id', $id)
                                        ->orderByDesc('empleado.nombre')
                                        ->first();


                         $areas = areas::select(['areas.*'])
                                   ->orderByDesc('areas.nombre')
                                   ->get();
                        $roles = roles::select(['roles.*'])
                        ->orderByDesc('roles.nombre')
                        ->get();
                                   
                 
    
                                   return view('empleados.edit', [
                                       'data' => $empleados,
                                       'roles' => $roles,
                                       'areas' => $areas
                                   ]);
}




public function guardarEditEmpleado(Request $request){

 $xhr_response = 400;

if(isset($request->boletin)){
$boletin=1;
} else{
$boletin=0;
}
if($request->name != "" && $request->email != "" && $request->gender != "" && $request->area != "" && $request->description != "" && $request->roles != ""){
    $empleados = empleado::select(['empleado.*'])
    ->where('empleado.id', $request->id)
    ->orderByDesc('empleado.nombre')
    ->first();

    $empleados->nombre = $request->name;
    $empleados->email = $request->email;
    $empleados->sexo = $request->gender;
    $empleados->area_id = $request->area;
    $empleados->boletin = $boletin;
    $empleados->descripcion = $request->description;
    $empleados->idRol = $request->roles;

    if($empleados->update()){

        $xhr_response = 200; 


    }

} else{

    $xhr_response = 401; 

}
    return $xhr_response;          
    
}


public function deleteEmpleado(Request $request){

 $empleados = empleado::select(['empleado.*'])
    ->where('empleado.id', $request->id)
    ->orderByDesc('empleado.nombre')
    ->first();

    if($empleados->delete()){
         $xhr_response=200;
    }else{
        $xhr_response=400;
    }
    
return $xhr_response;
}

}