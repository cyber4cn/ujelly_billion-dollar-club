<?php 

/**
 * Job details
 * 
 * This template is responsible for displaying job details on job details page
 * (template single.php) and job preview page (template preview.php)
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 */

 /* @var $job Wpjb_Model_Job */
 /* @var $company Wpjb_Model_Employer */

?>

    <?php $job = wpjb_view("job") ?>
    <table class="wpjb-info">
        <tbody>
            <?php if($job->company_name): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Company Name", WPJB_DOMAIN) ?></td>
                <td><?php wpjb_job_company($job) ?> <?php wpjb_job_company_profile($job->getEmployer(true)) ?></td>
            </tr>
            <?php endif; ?>
            <?php if($job->locationToString()): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Location", WPJB_DOMAIN) ?></td>
                <td>
                    <?php if(wpjb_conf("show_maps") && $job->getGeo()): ?>
                    <a href="#" class="wpjb-tooltip">
                      <img src="<?php echo wpjb_img("location.png") ?>" alt="" class="wpjb-inline-img" />
                      <span><img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $job->getGeo()->lnglat ?>&zoom=13&size=500x200&sensor=false" width="500" height="200" /></span>
                    </a>
                    <?php endif; ?>
                    
                    <?php esc_html_e($job->locationToString()) ?>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Date Posted", WPJB_DOMAIN) ?></td>
                <td><?php echo wpjb_job_created_at(get_option('date_format'), $job) ?></td>
            </tr>
            <?php if($job->job_category): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Category", WPJB_DOMAIN) ?></td>
                <td><?php wpjb_job_category() ?></td>
            </tr>
            <?php endif ?>
            <?php if($job->job_type): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Job Type", WPJB_DOMAIN) ?></td>
                <td><?php wpjb_job_type() ?></td>
            </tr>
            <?php endif; ?>
            <?php foreach($job->getNonEmptyFields() as $field): ?>
            <?php /* @var $field Wpjb_Model_FieldValue */ ?>
            <tr>
                <td class="wpjb-info-label"><?php esc_html_e($field->getLabel()); ?></td>
                <td><?php wpjb_field_value($field); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



    <div class="wpjb-job-content">

        <h3><?php _e("Description", WPJB_DOMAIN) ?></h3>
        <div class="wpjb-job-text">

            <?php if($job->getImageUrl()): ?>
            <div><img src="<?php echo $job->getImageUrl() ?>" id="wpjb-logo" alt="" /></div>
            <?php endif; ?>

            <?php wpjb_job_description($job) ?>
            
        </div>

        <?php foreach($job->getNonEmptyTextareas() as $field): ?>
        <h3><?php esc_html_e($field->getLabel()) ?></h3>
        <div class="wpjb-job-text"><?php wpjb_field_value($field) ?></div>
        <?php endforeach; ?>

    </div>
