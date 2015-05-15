<?php
/**
 * Description of CarrerBuilder
 *
 * @author greg
 * @package 
 */

class Wpjb_Service_CareerBuilder
{
    protected $_url = "http://api.careerbuilder.com/v1/";

    protected $_key = null;

    public function __construct($key)
    {
        $this->_key = $key;
    }

    public function search($keywords, $postedWithin, $country, $page, $perPage = 10, $location = "")
    {
        $query = array(
            "DeveloperKey" => $this->_key,
            "Keywords" => $keywords,
            "CountryCode" => $country,
            "PostedWithin" => $postedWithin,
            "PageNumber" => $page,
            "PerPage" => $perPage
        );

        if(!empty($location)) {
            $query["Location"] = $location;
        }

        $url = $this->_url."jobsearch?".http_build_query($query);
        $xml = simplexml_load_string($this->_download($url));

        if($xml->Errors->Error) {
            throw new Exception((string)$xml->Errors->Error);
        }
        if($xml->Errors[0]->Error) {
            throw new Exception((string)$xml->Errors[0]->Error);
        }
        if($xml->TotalCount == 0) {
            throw new Exception("No jobs found");
        }

        return $xml;
    }

    public function job($did)
    {
        $query = array(
            "DeveloperKey" => $this->_key,
            "DID" => $did
        );

        $url = $this->_url."job?".http_build_query($query);
        $xml = simplexml_load_string($this->_download($url));

        if($xml->Errors->Error) {
            throw new Exception((string)$xml->Errors->Error);
        }
        if($xml->Errors[0]->Error) {
            throw new Exception((string)$xml->Errors[0]->Error);
        }

        return $xml;
    }

    private static function _download($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}

?>