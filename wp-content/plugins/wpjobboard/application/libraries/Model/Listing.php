<?php
/**
 * Description of JobType
 *
 * @author greg
 * @package
 */

class Wpjb_Model_Listing extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_listing";

    /**
     * Discount object
     *
     * @var Wpjb_Model_Discount
     */
    private $_discount = null;

    protected function _init()
    {

    }

    public function getTextPrice($format = null)
    {
        $currency = Wpjb_List_Currency::getCurrency($this->currency);

        $price = $this->price;
        if($format) {
            $price = sprintf($format, $price);
        }

        if($currency['symbol'] != null) {
            return $currency['symbol'].$price;
        } else {
            return $currency['code'].' '.$price;
        }
    }

    public function addDiscount(Wpjb_Model_Discount $discount)
    {
        if($this->_discount instanceof Wpjb_Model_Discount) {
            throw new Exception("You can add only one discount!");
        }

        $this->_discount = $discount;
    }

    /**
     * @return array [(price-discount), discount]
     */
    public function calculatePrice()
    {
        if(!$this->_discount instanceof Wpjb_Model_Discount) {
            return array($this->price, 0);
        }

        $discount = $this->_discount->discount;
        if($this->_discount->type == 1) {
            $discount = round($this->price*$discount/100, 2);
        }

        $price = $this->price - $discount;

        return array($price, $discount);
    }
}

?>