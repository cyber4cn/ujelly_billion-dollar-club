<?php

/**
 * Company job stats
 * 
 * Template displays company jobs stats
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 */

 /* @var $jobList array List of jobs to display */
 /* @var $browse string One of: active; expired */
 /* @var $routerIndex string */
 /* @var $expiredCount int Total number of company expired jobs */
 /* @var $activeCount int Total number of company active jobs */

?>

<div id="wpjb-main" class="wpjb-page-company-panel">

    <?php wpjb_flash(); ?>

    <div class="wpjb-menu-bar">
        <?php if($browse == "active"): ?>
        <?php _e("Active listings", WPJB_DOMAIN); echo " ($activeCount)" ?> |
        <a href="<?php echo wpjb_link_to("employer_panel_expired") ?>"><?php _e("Expired listings", WPJB_DOMAIN); echo " ($expiredCount)" ?></a>
        <?php else: ?>
        <a href="<?php echo wpjb_link_to("employer_panel") ?>"><?php _e("Active listings", WPJB_DOMAIN); echo " ($activeCount)" ?></a> |
        <?php _e("Expired listings", WPJB_DOMAIN); echo " ($expiredCount)" ?>
        <?php endif; ?>
    </div>
    
    
    <table id="wpjb-job-list" class="wpjb-table">
        <thead>
            <tr>
                <th><?php _e("Expires in", WPJB_DOMAIN) ?></th>
                <th><?php _e("Title", WPJB_DOMAIN) ?></th>
                <th><?php _e("Statistics", WPJB_DOMAIN) ?></th>
                <th class="wpjb-last">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($jobList)): foreach($jobList as $job): ?>
            <tr class="<?php wpjb_job_features($job); wpjb_panel_features($job) ?>">
                <td class="wpjb-column-expires">
                    <?php if($job->expiresAt() === null): ?>
                        <?php _e("Never", WPJB_DOMAIN) ?>
                    <?php elseif($job->expired()): ?>
                        <?php _e("Expired", WPJB_DOMAIN) ?>
                    <?php else: ?>
                        <?php wpjb_time_ago($job->expiresAt(), "{time_ago}") ?>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo wpjb_link_to("job_edit", $job); ?>"><?php esc_html_e($job->job_title) ?></a>
                </td>
                <td>
                    <small>
                        <?php echo $job->stat_unique ?> <?php _e("views", WPJB_DOMAIN) ?> |
                        <?php if($job->stat_apply>0): ?>
                        <a href="<?php echo wpjb_link_to("job_applications", $job) ?>"><?php echo $job->stat_apply?> <?php _e("applications", WPJB_DOMAIN) ?></a>
                        <?php else: ?>
                        <?php echo $job->stat_apply ?> <?php _e("applications", WPJB_DOMAIN) ?>
                        <?php endif; ?>
                    </small>
                </td>
                <td class="wpjb-last">
                    <div class="company-panel-dropdown">
                        <img id="wpjb-dropdown-<?php echo $job->id ?>-img" src="<?php echo wpjb_img("cog.png") ?>" alt="" />
                        <ul id="wpjb-dropdown-<?php echo $job->id ?>" class="wpjb-dropdown">
                            <li><a href="<?php echo wpjb_link_to("job", $job) ?>"><?php _e("View job", WPJB_DOMAIN) ?></a></li>
                            <li><a href="<?php echo wpjb_link_to("job_edit", $job); ?>"><?php _e("Edit job", WPJB_DOMAIN) ?></a></li>
                            <li><a href="<?php echo wpjb_link_to("step_add")."republish/".$job->id ?>"><?php _e("Republish", WPJB_DOMAIN) ?></a></li>
                            <li><hr/></li>
                            <li><a href="<?php echo wpjb_link_to("job_applications", $job) ?>"><?php _e("Applicants", WPJB_DOMAIN) ?></a></li>
                            <li><hr/></li>
                            <?php if($job->is_filled): ?>
                            <li><a href="<?php echo wpjb_link_to($routerIndex)."notfilled/".$job->id ?>"><?php _e("Mark as not filled", WPJB_DOMAIN) ?></a></li>
                            <?php else: ?>
                            <li><a href="<?php echo wpjb_link_to($routerIndex)."filled/".$job->id ?>"><?php _e("Mark as filled", WPJB_DOMAIN) ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </td>
             </tr>
            <?php endforeach; else :?>
            <tr>
                <td colspan="4" align="center">
                    <?php _e("No job listings found.", WPJB_DOMAIN); ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="wpjb-paginate-links">
        <?php wpjb_paginate_links() ?>
    </div>


</div>

<script type="text/javascript">

    // 
    jQuery(function(){   
        
        jQuery(".company-panel-dropdown").wpjb_menu({
            position: "right"
        });
    });

</script>