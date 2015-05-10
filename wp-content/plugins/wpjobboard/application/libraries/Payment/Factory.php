<?php
/**
 * Creates instance of payment object
 *
 * @author greg
 */
class Wpjb_Payment_Factory
{
    protected $_engine = array();
    
    public function __construct()
    {
        foreach((array)glob(dirname(__FILE__)."/*.php") as $ajax) {
            $ctrl = basename($ajax, ".php");
            if(in_array($ctrl, array("Factory", "Interface"))) {
                continue;
            }
            $payment = "Wpjb_Payment_".$ctrl;
            $payment = new $payment;

            if($payment instanceof Wpjb_Payment_Interface) {
                $this->register($payment);
            }
        }
        
        apply_filters("wpjb_register_payment", $this);
    }
    
    /**
     * Returns payment class, identified by $engine variable
     *
     * @param string $engine
     * @param Wpjb_Model_Payment $payment
     * @return Wpjb_Payment_Interface
     */
    public static function factory(Wpjb_Model_Payment $payment)
    {
        $factory = new self();
        $engine = $payment->engine;
        if(!$factory->hasEngine($engine)) {
            throw new Exception("Payment engine [$engine] not registered!");
        }

        $class = $factory->getEngine($engine);
        $object = new $class($payment);
        return $object;
    }
    
    public function register(Wpjb_Payment_Interface $payment)
    {
        $this->_engine[$payment->getEngine()] = get_class($payment);
    }

    /**
     * Return all available payment engines
     *
     * @return array
     */
    public function getEngines()
    {
        return $this->_engine;
    }
    
    public function hasEngine($engine) 
    {
        if(isset($this->_engine[$engine])) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getEngine($engine)
    {
        return $this->_engine[$engine];
    }
}
?>
