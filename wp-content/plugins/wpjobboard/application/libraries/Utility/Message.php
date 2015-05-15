<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author greg
 */
class Wpjb_Utility_Message
{
    protected $_header = array();

    protected $_title = null;

    protected $_body = null;

    protected $_file = array();

    protected $_to = null;

    protected $_param = array();

    /**
     * Mail template
     *
     * @var Wpjb_Model_Mail
     */
    protected $_template = null;

    public function __construct($message)
    {
        $this->_template = new Wpjb_Model_Email($message);
        $this->setTitle($this->_template->mail_title);
        $this->setBody($this->_template->mail_body);
        $this->setFrom($this->_template->mail_from);
    }

    public function addHeader($key, $value)
    {
        $this->_header[$key] = $value;
    }

    public function getHeaders()
    {
        return $this->_header;
    }

    public function getFiles()
    {
        return array();
    }

    public function setFrom($email, $name = null)
    {
        if($name == null) {
            $name = $email;
        }

        $this->addHeader("From", "$name <$email>");
    }

    public function setTo($email)
    {
        $this->_to = $email;
    }

    public function getTo()
    {
        return $this->_to;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public function setBody($body)
    {
        $this->_body = $body;
    }

    public function getTemplate()
    {
        return $this->_template;
    }

    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    public function setParam($key, $value)
    {
        $this->_param[$key] = $value;
    }

    public function setParams(array $param)
    {
        foreach($param as $k => $v) {
            $this->setParam($k, $v);
        }
    }

    public function getParam($key)
    {
        if(!isset($this->_param[$key])) {
            return null;
        }
        
        return $this->_param[$key];
    }

    protected function _parse($text, $param)
    {
        $keys = array();
        $vars = array();
        foreach($param as $k => $v) {
            $keys[] = '{$'.$k.'}';
            $vars[] = $v;
        }

        return str_replace($keys, $vars, $text);
    }

    public function send()
    {
        $to = $this->getTo();
        $subject = $this->_parse($this->getTitle(), $this->_param);
        $message = $this->_parse($this->getBody(), $this->_param);
        $header = $this->getHeaders();
        $attachments = $this->getFiles();
        $headers = array();
        foreach($header as $t=>$x) {
            $headers[] = "$t: $x";
        }
        wp_mail($to, $subject, $message, $headers, $attachments);
    }
}
?>
