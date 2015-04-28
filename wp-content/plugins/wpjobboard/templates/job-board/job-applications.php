<?php

/**
 * Company job applications
 * 
 * Template displays job applications
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 */

 /* @var $applicantList array List of applications to display */
 /* @var $job string Wpjb_Model_Job */

?>

<div id="wpjb-main" class="wpjb-page-job-applications">

    <?php wpjb_flash(); ?>

    <div class="wpjb-menu-bar">
        <a href="<?php echo wpjb_link_to("employer_panel") ?>"><?php _e("Company jobs", WPJB_DOMAIN) ?></a>
        &raquo; <?php esc_html_e($job->job_title) ?>
    </div>

    <table class="wpjb-table">
        <thead>
            <tr>
                <th><?php _e("Applicant name", WPJB_DOMAIN) ?></th>
                <th><?php _e("E-mail", WPJB_DOMAIN) ?></th>
                <th class="wpjb-last"><?php _e("Freshness", WPJB_DOMAIN) ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($applicantList)) : foreach($applicantList as $application): ?>
            <tr class="">
                <td>
                    <a href="<?php echo wpjb_link_to("job_application", $application) ?>">
                        <?php if($application->applicant_name): ?>
                        <?php esc_html_e($application->applicant_name) ?>
                        <?php else: ?>
                        <?php _e("ID"); echo ": "; echo $application->id; ?>
                        <?php endif; ?>
                    </a><br />
                </td>
                <td>
                    <a class="wpjb-mail" href="mailto:<?php esc_attr_e($application->email) ?>"><?php esc_html_e($application->email) ?></a>
                </td>
                <td class="wpjb-last">
                    <?php echo wpjb_time_ago($application->applied_at) ?>
                </td>
             </tr>
            <?php endforeach; else :?>
            <tr>
                <td colspan="3" align="center">
                    <?php _e("No applicants found.", WPJB_DOMAIN); ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="wpjb_paginate_links">
        <?php wpjb_paginate_links() ?>
    </div>


</div>