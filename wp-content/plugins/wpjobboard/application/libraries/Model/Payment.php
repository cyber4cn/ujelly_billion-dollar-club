<?php
/**
 * Description of Payment
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_Payment extends Daq_Db_OrmAbstract
{
    const FOR_JOB = 1;
    const FOR_RESUMES = 2;

    protected $_name = "wpjb_payment";

    protected function _init()
    {
        $this->_reference["user"] = array(
            "localId" => "user_id",
            "foreign" => "Wpjb_Model_User",
            "foreignId" => "ID",
            "type" => "ONE_TO_ONE"
        );
    }

    public function toPay()
    {
        if($this->payment_sum == 0) {
            return null;
        }

        $curr = Wpjb_List_Currency::getCurrencySymbol($this->payment_currency);
        return $curr.$this->payment_sum;
    }

    public function paid()
    {
        if($this->payment_sum == 0) {
            return null;
        }

        $curr = Wpjb_List_Currency::getCurrencySymbol($this->payment_currency);
        return $curr.$this->payment_paid;
    }
}

?>