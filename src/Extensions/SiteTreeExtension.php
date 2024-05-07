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

        if(Environment::hasEnv($varname)) {
            $base_url = Environment::getEnv($varname);
            $base_url = rtrim($base_url, "/"); //remove trailing slashes
            //$base_parts = parse_url($base_url);

            $current_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'];
            
            if(!str_starts_with($base_url, $current_url)) {
                $target_url = $base_url.$_SERVER['REQUEST_URI'];
                
                $controller->redirect($target_url, 301);
                return;
            }
        }
    }

}
