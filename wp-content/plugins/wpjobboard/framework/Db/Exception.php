<?php
/**
 * Description of Exception
 *
 * @author greg
 * @package 
 */

class Daq_Db_Exception extends Exception
{

    public function __construct($message = null, $code = 0, $query = null)
    {
        if($message === null) {
            $message = "Error <code>".mysql_error()."</code>";
        }
        if($code === 0) {
            $code = mysql_errno();
        }

        parent::__construct($message." occured in query: <code>".$query."</code>", $code);
    }

}

?>