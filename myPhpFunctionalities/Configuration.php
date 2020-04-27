<?php
//config starts
spl_autoload_register(function($class){
    require_once 'myPhpFunctionalities/'. $class .'.php';
});
//SanitizeField starts
class SanitizeField
{
    static function clean($field)
    {

        $result = trim(addslashes(htmlentities(htmlspecialchars($field))));
        return $result;
    }
}
	
?>