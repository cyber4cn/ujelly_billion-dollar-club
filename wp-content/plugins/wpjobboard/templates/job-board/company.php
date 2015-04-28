<?php

/**
 * Company profile page
 * 
 * This template displays company profile page
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 */

/* @var $jobList array List of active company job openings */
/* @var $company Wpjb_Model_Company Company information */

?>

<div id="wpjb-main" class="wpjb-page-company" >

    <?php wpjb_flash() ?>

    <?php if($company->isVisible()): ?>

    <table class="wpjb-info">
        <tbody>
            <?php if($company->locationToString()): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Company Location", WPJB_DOMAIN) ?></td>
                <td>
                    <?php if($company->getGeo()): ?>
                    <a href="#" class="wpjb-tooltip">
                      <img src="<?php echo wpjb_img("location.png") ?>" alt="" class="wpjb-inline-img" />
                      <span><img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $company->getGeo()->lnglat ?>&zoom=13&size=500x200&sensor=false" width="500" height="200" /></span>
                    </a>
                    <?php endif; ?>
                    <?php esc_html_e($company->locationToString()) ?>
                </td>
            </tr>
            <?php endif; ?>
            
            <?php if($company->company_website): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Company Website", WPJB_DOMAIN) ?></td>
                <td><?php wpjb_company_website($company, __("Unknown", WPJB_DOMAIN)) ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="wpjb-job-content">

        <div class="wpjb-job-text">

            <?php if($company->getImageUrl()): ?>
            <div><img src="<?php echo $company->getImageUrl() ?>" id="wpjb-logo" alt="" /></div>
            <?php endif; ?>

            <?php wpjb_company_info($company) ?>

        </div>

        <h3><?php _e("Current job openings at", WPJB_DOMAIN) ?> <?php esc_html_e($company->company_name) ?></h3>
        <div class="wpjb-company-openings">
        <ul class="wpjb-company-list">
            <?php if (!empty($jobList)): foreach($jobList as $job): ?>
            <?php /* @var $job Wpjb_Model_Job */ ?>
            <li class="<?php wpjb_job_features($job); ?>">
                <?php if($job->isNew()): ?><img src="<?php wpjb_new_img(); ?>" alt="" class="wpjb-inline-img" /><?php endif; ?>
                <a href="<?php echo wpjb_link_to("job", $job); ?>"><?php esc_html_e($job->job_title) ?></a>
                <?php wpjb_job_created_time_ago(__("posted {time_ago} ago.", WPJB_DOMAIN), $job) ?>
             </li>
            <?php endforeach; else :?>
            <li>
                <?php _e("Currently this employer doesn't have any openings.", WPJB_DOMAIN); ?>
            </li>
            <?php endif; ?>
        </ul>
        </div>

    </div>

    <?php endif; ?>

</div>
