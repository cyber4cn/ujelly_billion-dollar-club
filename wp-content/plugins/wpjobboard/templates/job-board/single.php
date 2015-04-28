<?php

/**
 * Job details container
 * 
 * Inside this template job details page is generated (using function 
 * wpjb_job_template)
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 * @var $job Wpjb_Model_Job
 * @var $related array List of related jobs
 * @var $show_related boolean
 */

?>
<div id="wpjb-main" class="wpjb-job wpjb-page-single">

    <?php wpjb_flash() ?>
    <?php wpjb_job_template() ?>
    <?php wpjb_job_tracker() ?>

    <?php if($show_related && !empty($related)): ?>
    <div class="wpjb-job-content">
    <h3><?php _e("Related Jobs", WPJB_DOMAIN) ?></h3>
    <ul>
    <?php foreach($related as $relatedJob): ?>
    <?php /* @var $relatedJob Wpjb_Model_Job */ ?>
        <li class="<?php wpjb_job_features($relatedJob); ?>">

            <?php if($relatedJob->isNew()): ?><img src="<?php wpjb_new_img() ?>" alt="" class="wpjb-inline-img" /><?php endif; ?>
            <a href="<?php echo wpjb_link_to("job", $relatedJob); ?>"><?php esc_html_e($relatedJob->job_title) ?></a>
            <?php wpjb_job_created_time_ago(__("posted {time_ago} ago.", WPJB_DOMAIN), $relatedJob) ?>
         </li>
    <?php endforeach; ?>
    </ul>
    </div>
    <?php endif; ?>

    <div class="wpjb-job-apply">
        <a class="wpjb-button" href="<?php echo wpjb_link_to("apply", $job) ?>"><?php _e("Apply online", WPJB_DOMAIN) ?></a>
        <?php _e("or", WPJB_DOMAIN) ?>
        <a class="wpjb-cancel" href="<?php echo wpjb_url() ?>"><?php _e("cancel and go back", WPJB_DOMAIN) ?></a>

    </div>

</div>

