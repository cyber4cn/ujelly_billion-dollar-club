<?php
/**
 * Description of ${name}
 *
 * @author ${user}
 * @package 
 */

class Wpjb_Application_Resumes extends Wpjb_Application_Frontend
{
    public function getPage()
    {
        if(!is_null($this->_link)) {
            return $this->_link;
        }

        $this->_link = get_post(Wpjb_Project::getInstance()->conf("link_resumes"));

        return $this->_link;
    }

    public function getUrl()
    {
        global $wp_rewrite;

        $obj = $this->getPage();

        if($wp_rewrite->using_permalinks()) {
            $link = _get_page_link($obj->ID,false,false);
            $link = apply_filters('page_link', $link, $obj->ID, false);
            return rtrim($link, "/");
        } else {
            $link = 'index.php?page_id='.$obj->ID.'&job_resumes=';
            return rtrim(get_home_url(), "/")."/".$link;
        }
    }
}

?>
