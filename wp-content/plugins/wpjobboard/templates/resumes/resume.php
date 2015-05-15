<?php 

/**
 * Job details
 * 
 * This template is responsible for displaying job details on job details page
 * (template single.php) and job preview page (template preview.php)
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage Resumes
 */

 /* @var $resume Wpjb_Model_Resume */
 /* @var $can_browse boolean True if user has access to resumes */

?>

<div id="wpjb-main" class="wpjr-page-resume">

    <?php wpjb_flash() ?>

    
    <div class="wpjb-resume-headline">
        <img src="<?php echo wpjb_resume_photo() ?>" alt="" class="wpjb-resume-photo" />
        <strong><?php esc_html_e($resume->title) ?></strong>
        <i><?php esc_html_e($resume->headline) ?></i>
    </div>

    <table class="wpjb-info">
        <tbody>
            <tr>
                <td><?php _e("Last Resume Update", WPJB_DOMAIN) ?></td>
                <td><?php wpjb_resume_last_update_at(get_option('date_format'), $resume) ?></td>
            </tr>
            
            <?php if($resume->address): ?>
            <tr>
                <td><?php _e("Address", WPJB_DOMAIN) ?></td>
                <td><?php esc_html_e($resume->address) ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->degree): ?>
            <tr>
                <td><?php _e("Degree", WPJB_DOMAIN) ?></td>
                <td><?php wpjb_resume_degree($resume) ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->years_experience): ?>
            <tr>
                <td><?php _e("Experience", WPJB_DOMAIN) ?></td>
                <td><?php wpjb_resume_experience($resume) ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->category_id): ?>
            <tr>
                <td><?php _e("Category", WPJB_DOMAIN) ?></td>
                <td><?php esc_html_e($resume->getCategory(true)->title) ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->email): ?>
            <tr>
                <td><?php _e("E-mail", WPJB_DOMAIN) ?></td>
                <td><?php echo ($can_browse) ? $resume->email : wpjb_block_resume_details(); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->phone): ?>
            <tr>
                <td><?php _e("Phone Number", WPJB_DOMAIN) ?></td>
                <td><?php echo $can_browse ? $resume->phone : wpjb_block_resume_details() ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->website): ?>
            <tr>
                <td><?php _e("Website", WPJB_DOMAIN) ?></td>
                <td><?php echo $can_browse ? $resume->website : wpjb_block_resume_details() ?></td>
            </tr>
            <?php endif; ?>
            
            <?php foreach($resume->getNonEmptyFields() as $field): ?>
            <?php /* @var $field Wpjb_Model_FieldValue */ ?>
            <tr>
                <td><?php esc_html_e($field->getLabel()); ?></td>
                <td><?php wpjb_field_value($field) ?></td>
            </tr>
            <?php endforeach; ?>
            
            <?php if($resume->hasFile()): ?>
            <tr>
                <td><?php _e("File", WPJB_DOMAIN) ?></td>
                <td>
                    <?php if($can_browse): ?> 
                    <a href="<?php esc_attr_e($resume->getFileUrl()) ?>"><?php _e("download") ?></a>
                    <?php else: ?>
                    <?php wpjb_block_resume_details() ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>



    <div class="wpjb-job-content">
        <h3><?php _e("Experience", WPJB_DOMAIN) ?></h3>
        <div class="wpjb-job-text"><?php echo wpjb_rich_text($resume->experience) ?></div>
    </div>
    
    <div class="wpjb-job-content">
        <h3><?php _e("Education", WPJB_DOMAIN) ?></h3>
        <div class="wpjb-job-text"><?php echo wpjb_rich_text($resume->education) ?></div>
    </div>

    <?php foreach($resume->getNonEmptyTextareas() as $field): ?>
    <div class="wpjb-job-content">
        <h3><?php esc_html_e($field->getLabel()) ?></h3>
        <div class="wpjb-job-text"><?php wpjb_field_value($field) ?></div>
    </div>
    <?php endforeach; ?>

</div>
