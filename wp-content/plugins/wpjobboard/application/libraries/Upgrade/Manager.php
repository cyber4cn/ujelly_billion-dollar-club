<?php
/**
 * Description of Manager
 *
 * @author greg
 * @package 
 */

class Wpjb_Upgrade_Manager
{
    const ZIPERR_OPEN = -1;

    const ZIPERR_EXTRACT = -2;

    const URL = "http://api.wpjobboard.net/v1/";

    const CHECK = 86400;

    public static function updateTo($version)
    {
        /**
         * Stupidity protection
         * Throw an exception stating that i am idiot because i am trying to
         * overwrite my development files.
         */
        if(Wpjb_Project::VERSION == "#"."version"."#") {
            throw new Exception("You are an idiot! You cannot upgrade development version.");
        }

        $id = Wpjb_Utility_Seal::id();
        $ck = Wpjb_Utility_Seal::checksum();
        
        $version = Wpjb_Project::getInstance()->conf("upgrade")->available->version;

        $url = self::URL."download/id/".$id."/checksum/".$ck."/version/".$version;
        $file = Wpjb_List_Path::getPath("tmp_images")."/".md5($url).".zip";
        $data = self::_download($url);
        file_put_contents($file, $data);
        chmod($file, 0600);

        $baseDir = Wpjb_Project::getInstance()->getProjectBaseDir();
        //self::unzip($file, dirname($baseDir));

        $zip = new ZipArchive();
        if(!@$zip->open($file)) {
            unlink($file);
            return self::ZIPERR_OPEN;
        }
        if(!@$zip->extractTo(dirname($baseDir))) {
            unlink($file);
            return self::ZIPERR_EXTRACT;
        }
        
        self::upgrade();
        unlink($file);
    }

    public static function unzip($file, $dir)
    {
        $zip = new ZipArchive();
        $zip->open($file);
        $zip->extractTo($dir);
        return;

        $zip = zip_open($file);
        if(!is_resource($zip)) {
            return $zip;
        }
        while($zipEntry = zip_read($zip)) {
            $name = zip_entry_name($zipEntry);
            $size = zip_entry_filesize($zipEntry);
            $data = zip_entry_read($zipEntry, $size);

            if(substr($name, -1, 1) == "/") {
                if(!is_dir($dir."/".$name)) {
                    mkdir($dir."/".$name);
                }
            } else {
                $filename = $dir."/".$name;
                if(!is_file($filename) || md5(file_get_contents($filename)) != md5($data)) {
                    file_put_contents($filename, $data);
                }
            }
        }

        return true;
    }

    public static function upgrade($version = null)
    {
        $mask = dirname(__FILE__)."/*.php";
        if($version === null) {
            $version = Wpjb_Project::getInstance()->conf("version");
        }

        if($version == Wpjb_Project::VERSION) {
            return;
        }

        $flist = glob($mask);
        if(!is_array($flist)) {
            $flist = array();
        }

        foreach($flist as $file) {
            $name = pathinfo($file);
            $name = str_replace(".php", "", $name["basename"]);
            if(is_numeric($name)) {
                $name = "Wpjb_Upgrade_".$name;
                $update = new $name;
                if(!$update instanceof Wpjb_Upgrade_Abstract) {
                    continue;
                }

                if(version_compare($version, $update->getVersion()) === -1) {
                    $update->execute();
                }
            }
        }

        $instance = Wpjb_Project::getInstance();
        $instance->setConfigParam("version", Wpjb_Project::VERSION);
        $instance->saveConfig();
    }

    /**
     * Checks latest version data
     *
     * @return stdClass {version, date, }
     */
    public static function check($force = false)
    {

        $upgrade = Wpjb_Project::getInstance()->conf("upgrade");
        if(time() - $upgrade->lastcheck < self::CHECK && !$force) {
            return $upgrade;
        }

        $id = Wpjb_Utility_Seal::id();
        $ck = Wpjb_Utility_Seal::checksum();

        $version = Wpjb_Project::getInstance()->conf("version");

        $url = self::URL."release/id/".$id."/checksum/".$ck;

        if(!function_exists("curl_init")) {
            return new stdClass();
        }

        $json = json_decode(self::_download($url));

        if(isset($json->error)) {
            // fail silently
            return new stdClass();
        }

        if(!is_array($json)) {
            // fail silently
            return new stdClass();
        }

        $available = array();
        $key = null;

        foreach($json as $k => $ver) {
            if(version_compare($ver->version, $version) == 1) {
                $version = $ver->version;
                $key = $k;
            }
        }

        if($key !== null) {
            $available = $json[$key];
        }

        $upgrade = new stdClass();
        $upgrade->lastcheck = time();
        $upgrade->available = $available;

        $instance = Wpjb_Project::getInstance();
        $instance->setConfigParam("upgrade", $upgrade);
        $instance->saveConfig();

        return $upgrade;
    }

    private static function _download($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


}

?>