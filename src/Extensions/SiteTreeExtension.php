<?php

namespace Icecaster\DomainRedirect\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Environment;

class SiteTreeExtension extends Extension
{

    function contentcontrollerInit($controller) 
    {
        $varname = "SS_BASE_URL";

        if(Environment::isCli()) {
            return;
        }

        if($base_url = Environment::getEnv($varname)) {
            
            $base_url = rtrim($base_url, "/"); //remove trailing slashes

            $current_scheme = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? 
                $_SERVER['HTTP_X_FORWARDED_PROTO'] : $_SERVER['REQUEST_SCHEME'];

            $current_host = $_SERVER['SERVER_NAME'];
            
            $current_url = "{$current_scheme}://{$current_host}";

                        
            if(!str_starts_with($base_url, $current_url) && $base_url !== $current_url) {
                 $target_url = $base_url.$_SERVER['REQUEST_URI'];
                
                 $controller->redirect($target_url, 301);
                 return;
            }

        }
    }

}


