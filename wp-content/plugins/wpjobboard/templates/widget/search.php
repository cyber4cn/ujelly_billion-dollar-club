<?php

/**
 * Search jobs
 * 
 * Search jobs widget template file
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage Widget
 * 
 */


?>

<?php echo $theme->before_widget ?>
<?php if($title) echo $theme->before_title.$title.$theme->after_title ?>

<div id="wpjb_widget_alerts" class="wpjb_widget">
    
    <?php _e("Search Keyword" ,WPJB_DOMAIN) ?>
    <form action="<?php echo wpjb_link_to("search"); ?>" method="get">
        <?php if(!$use_permalinks): ?>
        <input type="hidden" name="page_id" value="<?php echo Wpjb_Project::getInstance()->conf("link_jobs") ?>" />
        <input type="hidden" name="job_board" value="find" />
        <?php endif; ?>
        <input type="text" name="query" />

        <input type="submit" value="<?php _e("Search", WPJB_DOMAIN) ?>" />
    </form>

</div>

<?php echo $theme->after_widget ?>