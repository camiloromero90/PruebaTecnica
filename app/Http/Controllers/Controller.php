<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function configuration(){

        define('CORE_MINIMUM_PHP', '7.2.24');
        if (version_compare(PHP_VERSION, CORE_MINIMUM_PHP, '<')){
            die('Your host needs to use PHP ' . CORE_MINIMUM_PHP . ' or higher to run this version of Core System, yur version is  !'.PHP_VERSION);
        }

        // Saves the start time and memory usage.
        $startTime = microtime(1);
        $startMem  = memory_get_usage();

        define('_JEXEC', 1);
        define('JPATH_INCLUDES', 'includes');
        define('JPATH_THEMES','themes');
        define('JPATH_SEPARATOR','.');

        if(view()->exists(JPATH_INCLUDES.'.defines')){

            $Config_ = Wj_templates_option::where('main',1)->first();
            if(!empty($Config_)){
                if(empty($Config_->nameDirectory)){
                    return json_encode(array(
                        'state' => 2,
                        'message' => 'tema esta vacio',
                        'codeState' => 'XXX'
                    ));
                }

                if(view()->exists(JPATH_THEMES .JPATH_SEPARATOR. $Config_->theme )){
                    $state= 1;
                    $action_="core.siteWeb";
                    $msg_ ="Success, ";
                    $msg_dev="";
                    $code_state=200;
                }else{
                    $state= 2;
                    $action_="";
                    $msg_ ="Error, Archivo del tema no encontrado";
                    $msg_dev="Error : not found (".JPATH_THEMES .".". $Config_->theme.")";
                    $code_state=404;
                }
            }else{
                $state= 2;
                $msg_ ="Error, Informacion del tema no encontrado, en la BD";
                $msg_dev="";
                $code_state=404;
            }

        }else{
            $state= 2;
            $msg_ ="Error, Directorio Defines";
            $msg_dev="";
            $code_state=404;
        }
        return json_encode(array(
            'state' => $state,
            'message' => $msg_,
            'message_develop' => $msg_dev,
            'codeState' => $code_state
        ));
    }
}
