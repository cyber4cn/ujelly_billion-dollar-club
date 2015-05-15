<?php
/*
 * lwdpt_1228422945_per@jadamspam.pl
 */

/**
 * Description of PayPal
 *
 * @author greg
 */
class Wpjb_Payment_PayPal implements Wpjb_Payment_Interface
{
    const ENV_SANDBOX = 1;
    const ENV_PRODUCTION = 2;


    /**
     * PayPal enviroment
     *
     * @var integer one of PayPal::ENV_<ENV>
     */
    private $_env;

    /**
     * List os PayPal currencies
     *
     * @var array
     */
    private static $_currency = array();

    /**
     * Job object
     *
     * @var Wpjb_Model_Job
     */
    private $_data = null;

    public function __construct(Wpjb_Model_Payment $data = null)
    {
        self::_init();
        $env = Wpjb_Project::getInstance()->conf("paypal_env", self::ENV_PRODUCTION);
        $this->setEnviroment($env);
        $this->_data = $data;
    }
    
    private static function _init()
    {
        self::$_currency = Wpjb_List_Currency::getAll();
    }

    public function getEngine()
    {
        return "PayPal";
    }

    public function getTitle()
    {
        return "PayPal";
    }

    public function setEnviroment($env = self::ENV_PRODUCTION)
    {
        $this->_env = $env;
    }

    public function getDomain()
    {
        if($this->_env == self::ENV_PRODUCTION)
        {
            return "www.paypal.com";
        }
        else
        {
            return "www.sandbox.paypal.com";
        }
    }

    /**
     * Depending on settings return either sandbox or production URL
     *
     * @return string
     */
    public function getUrl()
    {
        return "https://" . $this->getDomain() . "/cgi-bin/webscr";
    }

    /**
     * Returns PayPal eMail to which money will be sent.
     *
     * @return string
     */
    public function getEmail()
    {
        return Wpjb_Project::getInstance()->conf("paypal_email");
    }

    /**
     * Procesess PayPal transaction.
     *
     * @param array $ppData
     * @return boolean
     */
    public function processTransaction(array $data)
    {
        $ppData = $data;
        $req = 'cmd=_notify-validate';

        foreach ($ppData as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }

        // post back to PayPal system to validate
        $header  = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

        $fp = fsockopen ('ssl://'.$this->getDomain(), 443, $errno, $errstr, 30);

        $verified = false;
        if (!$fp) {
            throw new Exception("There was a HTTP error while connecting to PayPal server", 1);
        } else {
            fputs ($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets ($fp, 1024);
                if (strcmp ($res, "VERIFIED") == 0) {
                    $verified = true;
                } else if (strcmp ($res, "INVALID") == 0) {
                    throw new Exception("PayPal sent INVALID response.", 2);
                }
            }
            fclose ($fp);
        }

        if($verified) {
            if($ppData['payment_status'] != 'Completed') {
                throw new Exception("Payment Status != Completed", 3);
            }
            if($ppData['business'] != $this->getEmail()) {
                throw new Exception("Receiver email is invalid [".$ppData['business']."]", 4);
            }
            if($this->_data->payment_sum != $ppData['mc_gross']) {
                $sum = $this->_data->payment_sum;
                $msg = sprintf("Expected amount %2.f given %2.f.", $sum, $ppData['mc_gross']);
                throw new Exception($msg);
            }
            $curr = self::$_currency[$this->_data->payment_currency]['code'];
            if($curr != $ppData['mc_currency']) {
                $msg = sprintf("Expected currency %s given %s.", $curr, $ppData['mc_currency']);
                throw new Exception($msg);
            }
        }

        return null;
    }

    /**
     * Returns list of available currencies
     *
     * @return ArrayIterator
     */
    public static function getList()
    {
        self::_init();
        return new ArrayIterator(self::$_currency);
    }

    /**
     * Returns array representing given currency
     *
     * @param string $id
     * @return array
     */
    public static function getCurrency($id)
    {
        self::_init();
        if(isset(self::$_currency[$id])) {
            return self::$_currency[$id];
        }
        return array();
    }

    public static function getCurrencySymbol($code, $space = " ")
    {
        $currency = self::getCurrency($code);

        if(!is_null($currency['symbol'])) {
            return $currency['symbol'];
        } else {
            return $currency['code'].$space;
        }
    }

    public function render()
    {
        $router = Wpjb_Project::getInstance()->getApplication("frontend")->getRouter();
        /* @var $router Daq_Router */

        $notify = Wpjb_Project::getInstance()->getUrl()."/".$router->linkTo("step_notify", $this->_data);
        $complete = Wpjb_Project::getInstance()->getUrl()."/".$router->linkTo("step_complete", $this->_data);
        $amount = $this->_data->payment_sum-$this->_data->payment_paid;
        $currency = self::$_currency[$this->_data->payment_currency]['code'];
        $product = str_replace("{num}", $this->_data->getId(), __("Job Board order #{num} at: ", WPJB_DOMAIN));
        $product.= get_bloginfo("name");

        $html = "";
        $html.= '<form action="'.$this->getUrl().'" method="post">';
        $html.= '<input type="hidden" name="cmd" value="_xclick">';
        $html.= '<input type="hidden" name="business" value="'.$this->getEmail().'">';
        $html.= '<input type="hidden" name="lc" value="US">';
        $html.= '<input type="hidden" name="notify_url" value="'.$notify.'">';
        $html.= '<input type="hidden" name="return" value="'.$complete.'">';
        $html.= '<!--input type="hidden" name="rm" value="2"-->';
        $html.= '<input type="hidden" name="item_name" value="'.$product.'">';
        $html.= '<input type="hidden" name="amount" value="'.$amount.'">';
        $html.= '<input type="hidden" name="currency_code" value="'.$currency.'">';
        $html.= '<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">';
        $html.= '<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="">';
        $html.= '<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">';
        $html.= '</form>';

        return $html;
    }

}

?>