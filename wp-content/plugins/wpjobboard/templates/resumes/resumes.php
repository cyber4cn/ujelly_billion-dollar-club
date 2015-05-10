<?php 

/**
 * Resumes list
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage Resumes
 */

 /* @var $resumeList array of Wpjb_Model_Resume objects */
 /* @var $can_browse boolean True if user has access to resumes */

?>

<div id="wpjb-main" class="wpjr-page-resumes">

    <?php wpjb_flash(); ?>

    <table id="wpjb-resume-list" class="wpjb-table">
        <thead>
            <tr>
                <th><?php _e("Name", WPJB_DOMAIN) ?></th>
                <th><?php _e("Title", WPJB_DOMAIN) ?></th>
                <th class="wpjb-last"><?php _e("Last Update", WPJB_DOMAIN) ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($resumeList)) : foreach($resumeList as $resume): ?>
            <tr class="<?php wpjb_resume_mods(); ?>">
                <td>
                    <a href="<?php echo wpjr_link_to("resume", $resume) ?>"><?php esc_html_e($resume->firstname." ".$resume->lastname) ?></a>
                </td>
                <td>
                    <?php esc_html_e($resume->title) ?>
                </td>
                <td class="wpjb-last wpjb-column-date">
                    <?php wpjb_resume_last_update_at("M, d", $resume);?>
                </td>
             </tr>
            <?php endforeach; else :?>
            <tr>
                <td colspan="3" align="center">
                    <?php _e("No resumes found.", WPJB_DOMAIN); ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="wpjb-paginate-links">
        <?php wpjr_paginate_links() ?>
    </div>


</div>
