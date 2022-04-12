<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'empleados' ], function(){
    Route::get('list/', [ 'uses' =>'App\Http\Controllers\empleadosController@listEmpleado' ]);    
    Route::get('nuevoEmpleado/', [ 'uses' =>'App\Http\Controllers\empleadosController@nuevoEmpleado' ]);
    Route::post('crearEmpleado/', [ 'uses' =>'App\Http\Controllers\empleadosController@crearEmpleado' ]);
    Route::get('editEmpleado/{id}', [ 'uses' =>'App\Http\Controllers\empleadosController@editEmpleado' ]);
    Route::post('guardarEditEmpleado/', [ 'uses' =>'App\Http\Controllers\empleadosController@guardarEditEmpleado' ]);
    Route::post('deleteEmpleado', [ 'uses' =>'App\Http\Controllers\empleadosController@deleteEmpleado' ]);
 });