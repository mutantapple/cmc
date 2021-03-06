<?php
/*
 * Copyright 2012 - Phillip Tarrant
 * License: http://creativecommons.org/licenses/by-sa/3.0/deed.en_US
 */
if (!defined('APP_NAME')) die('NO DIRECT SCRIPT ACCESS!');

/* =============================================================================
 * pf_controller - our base functions for controllers to use. Designed to be 
 * extended by the apps controllers, abstract so it can't be called directly.
 * ===========================================================================*/

abstract class pf_controller
{
    private static function loadFile($file,$dir,$data=array())
    {
        //make sure the config file is carried along anytime a file is loaded
        $file = pf_core::makePHPExtention($file);
        
        if (file_exists($dir. DS. $file))
        {
            require ($dir.DS.$file);
            return true;
        }
        return false;
    }
    
    public static function loadView($file,$data=array())
    {
        pf_events::eventsAdd('Attempting To Load File: '.$file);
        if (!self::loadFile($file, APPLICATION_DIR.'pages',$data))
        {
            pf_events::eventsAdd('Unable To Load File: '.$file);
            pf_core::loadTemplate('404');
        }
    }
    
    //loads a library if it exist
    public static function loadLibrary($file)
    {
        if (!self::loadFile($file, APPLICATION_DIR.'lib')) return FALSE;
        else return true;
    }
    
    //checks to see if logged in, if not, loads the login page specified in config file
    public static function checkLogin()
    {
        if(!pf_auth::checkLogin())
        {
            pf_core::redirectUrl(MAIN_PAGE."/".pf_config::get('login_page'));
        }
        else return true;
        
    }

    //loads a model
    public static function loadModel($file)
    {
        if (!self::loadFile($file, APPLICATION_DIR.'models')) return FALSE;
    }
}
?>
