<?php

/**
 * Job application details
 *
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 /* @var $job Wpjb_Model_Job */
 /* @var $application Wpjb_Model_Application */

?>

<div id="wpjb-main" class="wpjb-page-job-application">

    <?php wpjb_flash(); ?>
    
    <div class="wpjb-menu-bar">
        <a href="<?php echo wpjb_link_to("employer_panel") ?>"><?php _e("Company jobs", WPJB_DOMAIN) ?></a>
        &raquo; 
        <a href="<?php echo wpjb_link_to("job_applications", $job) ?>"><?php esc_html_e($job->job_title) ?></a>
        &raquo;
        <?php _e($application->applicant_name) ?>
    </div>
    
    
    <table class="wpjb-info">
        <tbody>
            <tr>
                <td><?php _e("Application Status", WPJB_DOMAIN) ?></td>
                <td>
                    <?php if($application->is_rejected): ?>
                    <?php _e("Rejected") ?>
                    (<a href="<?php echo wpjb_link_to("application_accept", $application) ?>"><?php _e("Accept", WPJB_DOMAIN) ?></a>)
                    <?php else: ?>
                    <?php _e("Accepted") ?>
                    (<a href="<?php echo wpjb_link_to("application_reject", $application) ?>"><?php _e("Reject", WPJB_DOMAIN) ?></a>)
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><?php _e("Applicant Name", WPJB_DOMAIN) ?></td>
                <td><?php echo $application->applicant_name ?></td>
            </tr>
            <tr>
                <td><?php _e("Applicant E-mail", WPJB_DOMAIN) ?></td>
                <td><?php echo $application->email ?></td>
            </tr>
            <tr>
                <td><?php _e("Date Sent", WPJB_DOMAIN) ?></td>
                <td><?php echo wpjb_date("d M, Y", $application->applied_at) ?></td>
            </tr>
            <?php foreach($application->getNonEmptyFields() as $field): ?>
            <tr>
                <td><?php echo esc_html($field->getField()->label) ?></td>
                <td><?php echo esc_html($field->value) ?></td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(count($application->getFiles())): ?>
            <tr>
                <td><?php _e("Attached Files", WPJB_DOMAIN) ?></td>
                <td>
                    <?php foreach($application->getFiles() as $file): ?>
                    <a href="<?php echo esc_attr($file->url) ?>"><?php echo esc_html($file->basename) ?></a>
                    ~ <?php echo esc_html(wpjb_format_bytes($file->size)) ?>
                    <br/>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="wpjb-job-content">
        <h3><?php _e("Message", WPJB_DOMAIN) ?></h3>
        <div class="wpjb-job-text">
            <?php echo $application->resume ?>
        </div>

        <?php foreach($application->getNonEmptyTextareas() as $field): ?>
        <h3><?php echo esc_html($field->getField()->label) ?></h3>
        <div class="wpjb-job-text"><?php echo wpjb_rich_text($field->value) ?></div>
        <?php endforeach; ?>
    </div>

</div>