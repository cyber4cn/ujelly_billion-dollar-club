<?php

/**
 * Jobs list
 * 
 * This template file is responsible for displaying list of jobs on job board
 * home page, category page, job types page and search results page.
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 * @var $jobList array List of jobs to display
 * @var $current_category Wpjb_Model_Category Available if browsing jobs by category
 * @var $current_type Wpjb_ModelJobType Available if browsing jobs by type
 */

?>

<div id="wpjb-main" class="wpjb-page-index">

    <?php wpjb_flash(); ?>

    <?php if(wpjb_description()): ?>
    <div><?php echo wpjb_description() ?></div>
    <?php endif; ?>

    
    <table id="wpjb-job-list" class="wpjb-table">
        <thead>
            <tr>
                <th><?php _e("Job title", WPJB_DOMAIN) ?></th>
                <th><?php _e("Location", WPJB_DOMAIN) ?></th>
                <th class="wpjb-last"><?php _e("Posted", WPJB_DOMAIN) ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($jobList)) : foreach($jobList as $job): ?>
        <?php /* @var $job Wpjb_Model_Job */ ?>
            <tr class="<?php wpjb_job_features($job); ?>">
                <td class="wpjb-column-title">
                    <a href="<?php echo wpjb_link_to("job", $job) ?>"><?php esc_html_e($job->job_title) ?></a>
                    <?php if($job->isNew()): ?><img src="<?php wpjb_new_img() ?>" alt="" class="wpjb-inline-img" /><?php endif; ?>
                    <small class="wpjb-sub"><?php esc_html_e($job->company_name) ?></small>
                </td>
                <td class="wpjb-column-location">
                    <?php esc_html_e($job->locationToString()) ?>
                </td>
                <td class="wpjb-column-date wpjb-last">
                    <?php echo wpjb_job_created_at("M, d", $job); ?>
                    <small class="wpjb-sub" style="color:<?php echo $job->getType()->getHexColor() ?>">
                    <?php esc_html_e($job->getType()->title) ?>
                    </small>
                </td>
             </tr>
            <?php endforeach; else :?>
            <tr>
                <td colspan="3" class="wpjb-table-empty">
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