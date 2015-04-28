<?php
/**
 * Description of Int
 *
 * @author greg
 * @package
 */

class Daq_Filter_WP_Url implements Daq_Filter_Interface
{
    public function filter($value)
    {
        return esc_url_raw($value);
    }
}

?>