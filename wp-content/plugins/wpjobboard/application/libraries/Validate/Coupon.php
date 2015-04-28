<?php
/**
 * Description of Coupon
 *
 * @author greg
 * @package 
 */

class Wpjb_Validate_Coupon
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{

    private $_currency = null;

    public function __construct($currency = null)
    {
        $this->_currency = $currency;
    }

    public function isValid($value)
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_Discount t")
            ->where("code = ?", $value)
            ->limit(1)
            ->execute();

        if(!isset($result[0])) {
            $this->setError(__("Coupon code does not exist.", WPJB_DOMAIN));
            return false;
        }

        $discount = $result[0];
        if(!$discount->is_active) {
            $this->setError(__("Coupon code is not active.", WPJB_DOMAIN));
            return false;
        }

        if(strtotime("now") > strtotime($discount->expires_at)) {
            $this->setError(__("Coupon code expired.", WPJB_DOMAIN));
            return false;
        }

        if($discount->max_uses > 0 && $discount->used >= $discount->max_uses) {
            $this->setError(__("Coupon code expired.", WPJB_DOMAIN));
            return false;
        }

        if($this->_currency!==null && $discount->type==2 && $this->_currency!=$discount->currency) {
            $this->setError(__("Currency does not match.", WPJB_DOMAIN));
            return false;
        }

        return true;
    }
}
?>