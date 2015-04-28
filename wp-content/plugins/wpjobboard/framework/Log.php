<?php
/**
 * Description of Log
 *
 * @author greg
 * @package 
 */

class Daq_Log
{
    /**
     * Path to directory containing log files
     *
     * @var string
     */
    protected $_path = null;

    /**
     * Error log file name
     *
     * @var string
     */
    protected $_errorLog = null;

    /**
     * Debug log file name
     *
     * @var string
     */
    protected $_debugLog = null;

    public function __construct($path, $errorLog, $debugLog)
    {
        $this->_path = $path;
        $this->_errorLog = $errorLog;
        $this->_debugLog = $debugLog;
    }
}

?>