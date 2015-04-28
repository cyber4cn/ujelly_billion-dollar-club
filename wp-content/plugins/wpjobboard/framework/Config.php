<?php
/**
 * Description of Config
 *
 * @author greg
 * @package 
 */

class Daq_Config
{
    public static function parseIni($default, $ext = null, $sections = false)
    {
        if(!is_file($default)) {
            throw new Exception("Default config file [$default] does not exist.");
        }

        $ini = parse_ini_file($default, $sections);

        if(!is_file($ext)) {
            return $ini;
        }

        $ext = parse_ini_file($ext, $sections);

        foreach($ext as $k => $v) {
            if(isset($ini[$k]) && is_array($ini[$k])) {
                $ini[$k] = array_merge($ini[$k], $v);
            } else {
                $ini[$k] = $v;
            }
        }

        return $ini;
    }
}

?>