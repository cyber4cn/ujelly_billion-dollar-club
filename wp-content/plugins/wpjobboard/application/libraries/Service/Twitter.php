<?php
/**
 * Description of Twitter
 *
 * @author greg
 * @package 
 */

class Wpjb_Service_Twitter
{
    public static function tweet(Wpjb_Model_Job $job)
    {
        //$url = "http://cnn.com";
        $url = Wpjb_Project::getInstance()->router()->linkTo("job", $job);
        $url = Wpjb_Project::getInstance()->getUrl()."/".$url;
        $url = Wpjb_Service_BitLy::shorten($url);

        $exchange = array(
            "{url}" => $url,
            "{category}" => $job->getCategory(true)->title,
            "{type}" => $job->getType(true)->title,
        );

        $msg = str_replace(
            array_keys($exchange),
            array_values($exchange),
            Wpjb_Project::getInstance()->conf("posting_tweet_template")
        );

        $len = strlen(str_replace("{title}", $job->job_title, $msg));
        if($len>140) {
            $title = substr($job->job_title, 0, $len-140)."...";
        } else {
            $title = $job->job_title;
        }

        $msg = str_replace("{title}", $job->job_title, $msg);
        self::_send($msg);
    }

    protected static function _send($msg)
    {
        $path = Wpjb_List_Path::getPath("vendor");
        require_once $path."/TwitterOAuth/OAuth.php";
        require_once $path."/TwitterOAuth/TwitterOAuth.php";

        //$user = Wpjb_Project::getInstance()->conf("api_twitter_username");
        //$pass = Wpjb_Project::getInstance()->conf("api_twitter_password");

        $ck = Wpjb_Project::getInstance()->conf("api_twitter_consumer_key");
        $cs = Wpjb_Project::getInstance()->conf("api_twitter_consumer_secret");
        $ot = Wpjb_Project::getInstance()->conf("api_twitter_oauth_token");
        $os = Wpjb_Project::getInstance()->conf("api_twitter_oauth_secret");

        $connection = new TwitterOAuth($ck, $cs, $ot, $os);
        $content = $connection->get('account/verify_credentials');

        if(isset($content->error)) {
            throw new Exception($content->error);
        }

        $connection->post('statuses/update', array('status' => $msg));
        
        return null;
    }
}

?>