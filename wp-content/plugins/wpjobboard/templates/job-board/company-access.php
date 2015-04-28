<div id="wpjb_company_access" class="wpjb-main">

    <?php wpjb_flash() ?>

<?php if($access == 2): ?>


    <?php if($already_requested): ?>

    <?php elseif($request_sent): ?>

        <div style="margin-top:10px">
            <?php _e("Once your employer account is approved you will be notified by email.") ?>
        </div>

    <?php else: ?>

        <?php if($object->is_active == 4): ?>
        <div style="margin-top:10px">
            <?php _e("You have already been granted full access to employee resumes.", WPJB_DOMAIN) ?>
        </div>
        <?php else: ?>
        <div style="margin-top:10px">
            <?php _e("For security reasons, employers have to manually request resumes access.", WPJB_DOMAIN) ?>
        </div>

        <div style="margin-top:10px">
            <?php _e("Before requesting access to user resumes please fill your", WPJB_DOMAIN) ?>
            <a href="<?php echo wpjb_link_to("employer_edit") ?>"><?php _e("company profile", WPJB_DOMAIN) ?></a>
        </div>

        <p id="wpjb-employer-actions" class="submit wpjb-import-box">
            <form action="" method="post" id="">
            <input type="hidden" name="request_employer" value="1" />
            <input type="submit" value="<?php _e("Request resumes access now!", WPJB_DOMAIN) ?>" id="wpjb-start-import" class="button-primary" />
            </form>
        </p>

        <?php endif; ?>

    <?php endif; ?>


<?php elseif($access == 3): ?>


    <?php if($purchase==1): ?>

        <div style="margin-top:10px">
            <h3 style="padding-left:10px"><?php _e("Total Cost", WPJB_DOMAIN) ?>: <?php echo $payment ?></h3>
            <h3 style="padding-left:10px"><?php _e("Extends Account Until", WPJB_DOMAIN) ?>: <?php echo date("Y-m-d", $active_until) ?></h3>
        </div>
        <div class="wpjb_employer_paypal">
            <?php echo $paypal->render(); ?>
        </div>

    <?php else: ?>

        <p>
            Each purchase cost <strong><?php echo $payment ?></strong> and extends your access for next
            <strong><?php echo Wpjb_Project::getInstance()->conf("cv_extend"); ?> days</strong>.
            Until <?php echo date("Y-m-d", $active_until) ?>
        </p>

        <?php $employer = Wpjb_Model_Employer::current(); ?>
        <?php $time = strtotime($employer->access_until); ?>
        <?php if($time !== false): ?>
        <ul>
            <?php if($time > time()): ?>
            <li><?php _e("Your access expires on", WPJB_DOMAIN) ?>:
                <span>
                    <?php echo $employer->access_until ?>
                    (<?php echo __("in", WPJB_DOMAIN)." ".daq_time_ago_in_words($time) ?>)
                </span>
            </li>
            <?php else: ?>
            <li><?php _e("Your access expired on", WPJB_DOMAIN) ?>:
                <span style="color:red">
                    <?php echo $employer->access_until ?>
                    (<?php echo daq_time_ago_in_words($time)." ".__("ago", WPJB_DOMAIN) ?>)
                </span>
            </li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>

        <p id="wpjb-employer-actions" class="submit wpjb-import-box">
            <form class="wpjb-form" action="<?php echo wpjb_link_to("employer_access") ?>" method="post" id="">
            <?php wpjb_form_render_hidden($form) ?>
            
            <?php foreach($form->getNonEmptyGroups() as $group): ?>
            <?php foreach($group->element as $name => $field): ?>
            <fieldset>
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
            </fieldset>
            <?php endforeach; ?>
            <?php endforeach; ?>
            <input type="submit" value="<?php _e("Purchase resumes access now!", WPJB_DOMAIN) ?>" id="wpjb-start-import" class="button-primary" />
            </form>
        </p>


    <?php endif; ?>


<?php elseif($access == 1 || $access == 4): ?>


    <div style="margin-top:10px">
        <?php _e("You already have full resumes access.", WPJB_DOMAIN) ?>
    </div>


<?php endif; ?>

</div>