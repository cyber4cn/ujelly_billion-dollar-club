<?php /* @var $resume Wpjb_Model_Resume */ ?>
<div id="wpjb-main" class="wpjr-page-my-resume">

    <?php wpjb_flash() ?>

    <form action="" method="post" id="wpjb-resume" class="wpjb-form" enctype="multipart/form-data">

        <fieldset>
            <legend><?php _e("Resume Information", WPJB_DOMAIN) ?></legend>
            <div>
                <label class="wpjb-label"><?php _e("Resume Status", WPJB_DOMAIN) ?></label>
                <span><?php echo wpjb_resume_status($resume) ?></span>
            </div>
            <div>
                <label class="wpjb-label"><?php _e("Last Updated", WPJB_DOMAIN) ?></label>
                <span><?php echo wpjb_resume_last_update("d M, Y", $resume) ?></span>
            </div>
            <?php if($resume->hasImage()): ?>
            <div>
                <label class="wpjb-label"><?php _e("Profile Image", WPJB_DOMAIN) ?></label>
                <span>
                    <a href="<?php echo $resume->getImageUrl() ?>" class="wpjb-button"><?php _e("Preview", WPJB_DOMAIN) ?></a>
                    <a href="<?php echo wpjr_link_to("myresumedel") ?>" class="wpjb-button"><?php _e("Delete photo", WPJB_DOMAIN) ?></a>
                </span>
            </div>
            <?php endif; ?>
            <?php if($resume->hasFile()): ?>
            <div>
                <label class="wpjb-label"><?php _e("File", WPJB_DOMAIN) ?></label>
                <span>
                    <a href="<?php echo $resume->getFileUrl() ?>" class="wpjb-button"><?php _e("Download", WPJB_DOMAIN) ?></a>
                    <a href="<?php echo wpjr_link_to("myresumedel_file") ?>" class="wpjb-button"><?php _e("Delete file", WPJB_DOMAIN) ?></a>
                </span>
            </div>
            <?php endif; ?>
        </fieldset>

        <?php wpjb_form_render_hidden($form) ?>
        <?php foreach($form->getNonEmptyGroups() as $group): ?>
        <?php /* @var $group stdClass */ ?> 
        <fieldset class="wpjb-fieldset-<?php echo $group->name ?>">
            <legend class="wpjb-empty"><?php esc_html_e($group->legend) ?></legend>
            <?php foreach($group->element as $name => $field): ?>
            <?php /* @var $field Daq_Form_Element */ ?>
            <div class="<?php wpjb_form_input_features($field) ?>">

                <label class="wpjb-label">
                    <?php esc_html_e($field->getLabel()) ?>
                    <?php if($field->isRequired()): ?><span class="wpjb-required">*</span><?php endif; ?>
                </label>
                
                <div class="wpjb-field">
                    <?php wpjb_form_render_input($form, $field) ?>
                    <?php wpjb_form_input_hint($field) ?>
                    <?php wpjb_form_input_errors($field) ?>
                </div>

            </div>
            <?php endforeach; ?>
        </fieldset>
        <?php endforeach; ?>
    
        <p class="submit">
        <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
        </p>

    </form>

<script type="text/javascript">
<?php if(Wpjb_Project::getInstance()->conf("cv_approval")==1 && wpjb_resume()->is_approved == Wpjb_Model_Resume::RESUME_APPROVED): ?>
   WpjbResume.Message = "<?php _e("Wait! Your resume next status will be 'pending approval' and it won't be visible until Administrator manually approve it. Do you want to continue?", WPJB_DOMAIN) ?>";
   WpjbResume.Init();
<?php endif; ?>
<?php if(wpjb_resume()->hasImage()): ?>
    WpjbResume.Avatar = "<?php echo wpjb_resume()->getImageUrl() ?>";
<?php endif; ?>
    WpjbResume.HandleImage();
</script>




</div>