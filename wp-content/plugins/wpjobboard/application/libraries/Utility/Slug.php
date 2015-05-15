<?php
/**
 * Description of Slug
 *
 * @author greg
 * @package 
 */

class Wpjb_Utility_Slug
{
    const MODEL_JOB = "job";

    const MODEL_TYPE = "type";

    const MODEL_CATEGORY = "category";

    public static function generate($model, $title, $id = null)
    {
        $list = array(
            "job"       => array("model" => "Wpjb_Model_Job", "field" => "job_slug"),
            "type"      => array("model" => "Wpjb_Model_JobType", "field" => "slug"),
            "category"  => array("model" => "Wpjb_Model_Category", "field" => "slug")
        );

        $slug = sanitize_title_with_dashes($title);
        $slug = preg_replace("([^A-z0-9\-]+)", "", $slug);

        $newSlug = $slug;
        $isUnique = true;

        $query = new Daq_Db_Query();
        $query->select("t.".$list[$model]['field'])
            ->from($list[$model]['model']." t")
            ->where("(".$list[$model]['field']." = ?", $newSlug)
            ->orWhere($list[$model]['field']." LIKE ? )", $newSlug."%");

        if($id>0) {
            $query->where("id <> ?", $id);
        }

        $field = "t__".$list[$model]['field'];
        $list = array();
        $c = 0;

        foreach($query->fetchAll() as $q) {
            $list[] = $q->$field;
            $c++;
        }

        if($c > 0) {
            $isUnique = false;
            $i = 1;
            do {
                $i++;
                $newSlug = $slug."-".$i;
                if(!in_array($newSlug, $list)) {
                    $isUnique = true;
                }
            } while(!$isUnique);
        }

        return $newSlug;
    }
}

?>