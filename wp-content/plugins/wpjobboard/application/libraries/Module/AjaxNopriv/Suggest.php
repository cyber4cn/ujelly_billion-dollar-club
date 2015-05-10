<?php

/**
 * Description of ${name}
 *
 * @author ${user}
 * @package 
 */
class Wpjb_Module_AjaxNopriv_Suggest
{
    public function stateAction()
    {
        $request = Daq_Request::getInstance();
        $pattern = $request->get("q", "");
        $country = $request->get("country", 0);
        
        $arr = Wpjb_List_State::find($pattern, $country);

        if(empty($arr)) {
            // try to get at least some suggestions
            $query = new Daq_Db_Query;
            $query->select("*");
            $query->from("Wpjb_Model_Job t");
            $query->where("job_state LIKE ?", "%$pattern%");
            $query->group("job_state");
            $query->limit(10);
            $result = $query->execute();

            foreach($result as $r) {
                $arr[] = $r->job_state;
            }
        }
        
        echo join("\r\n", $arr);
        exit;
    }
    
    public function cityAction()
    {
        $request = Daq_Request::getInstance();
        $pattern = $request->get("q");
        $country = $request->get("country", 0);
        $state = $request->get("state", "");
        
        $query = new Daq_Db_Query;
        $query->select("*");
        $query->from("Wpjb_Model_Job t");
        if($country>0) {
            $query->where("job_country = ?", $country);
        }
        if(!empty($state)) {
            $query->where("job_state LIKE ?", "%$state%");
        }
        $query->where("job_location LIKE ?", "%$pattern%");
        $query->group("job_location");
        $query->limit(10);
        
        $result = $query->execute();
        $arr = array();
        
        foreach($result as $r) {
            $arr[] = $r->job_location;
        }
        
        echo join("\r\n", $arr);
        exit;
        
    }
}
?>
