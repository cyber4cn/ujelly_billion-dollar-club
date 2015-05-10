<?php

/**
 * Description of ${name}
 *
 * @author ${user}
 * @package 
 */
class Daq_Helper_Html
{
    public function input(array $attr = null)
    {        
        foreach($attr as $k => $v) {
            if($v == false) {
                continue;
            }
            $arr[$k] = esc_attr($v);
        }
        
        $merged = array();
        foreach($arr as $k => $v) {
            $merged[] = "$k=\"$v\"";
        }
        
        echo "<input ".join(" ", $merged)." />";
    }
}
?>
