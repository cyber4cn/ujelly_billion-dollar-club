<div id="wpjb-main" class="wpjb-page-job-edit">

    <p><a href="<?php echo wpjb_link_to("employer_panel") ?>">&larr; <?php _e("Go back") ?></a></p>

    <?php wpjb_flash() ?>

    <form class="wpjb-form" action="" method="post" enctype="multipart/form-data">

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
        <fieldset>
            <legend class="wpjb-empty"></legend>
            <input type="submit" name="wpjb_preview" id="wpjb_submit" value="<?php _e("Update", WPJB_DOMAIN) ?>" />
        </fieldset>

    </form>

</div>