<?php if (!defined('APP_NAME')) die('NO DIRECT SCRIPT ACCESS!');

class pf_auth {
    
    public static function saveVar($var,$data)
    {
        $_SESSION[$var]=$data;
    }
    
    public static function getVar($var)
    {
        if (key_exists($var, $_SESSION))return $_SESSION[$var];
        else return false;
    }
    
    public static function delVar($var)
    {
        if (key_exists($var, $_SESSION))unset($_SESSION[$var]);
    }
    
    public static function setLoggedin($value=null)
    {
        if (isset($value)) self::saveVar ('loggedin', $value);
        self::saveVar('loggedin', TRUE);
    }
    
    public static function checkLogin($redirect=null)
    {
        if ((isset($redirect)) && (!self::getVar('loggedin')))
        {
            pf_core::redirectUrl($redirect);
        }
        
        return self::getVar('loggedin');
    }
    
    public static function loggout()
    {
        $_SESSION=array();
        session_destroy();
    }
}

?>
