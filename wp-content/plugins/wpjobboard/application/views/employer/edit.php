<?php $job_id = ($revoke_access) ? "N/A" : $form->getObject()->getId(); ?>
<?php $title = __("Edit Job | ID: {id}", WPJB_DOMAIN) ?>
<?php $this->slot("title", str_replace("{id}", $job_id, $title)); ?>
<?php $this->_include("header.php"); ?>
<?php if(!$revoke_access): ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/employer", "index"); ?>"class="button button-highlighted">
        <?php _e("Go back", WPJB_DOMAIN) ?>
    </a>
</div>

<script type="text/javascript">
    <?php $value = $form->getValues(); ?>
    Wpjb.JobState = "<?php echo($value['job_country'] == 840 ? '' : $form->getObject()->job_state); ?>";
    Wpjb.Id = <?php echo $form->getObject()->getId() ?>;
</script>

<?php if($form->getObject()->hasImage()): ?>
<form action="" method="post" id="wpjb-remove-image-form">
    <input type="hidden" name="remove_image" id="wpjb-remove-image-form-input" value="-1" />
    <input type="hidden" name="id" value="<?php echo $form->getObject()->getId() ?>" />
</form>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data" class="wpjb-form">
    <table class="form-table">
        <tbody>
        <?php if($form->getObject()->getId()>0): ?>
        <?php $obj = $form->getObject(); ?>
        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php _e("Job Information", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Created At", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td"><?php echo $form->getObject()->job_created_at ?></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Expires", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php if($obj->job_visible>0): ?>
                <?php echo $obj->expiresAt(true)  ?> (<?php _e("Number of days visible", WPJB_DOMAIN) ?>: <?php echo $obj->job_visible ?>)
                <?php else: ?>
                <i><?php _e("never", WPJB_DOMAIN) ?></i>
                <?php endif; ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Payment Amount", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php echo (!$obj->isFree() ? $obj->paymentAmount() : "<i>".__("free listing", WPJB_DOMAIN)."</i>") ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Paid", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php if($obj->isFree()): ?>
                <i><?php _e("not applicable", WPJB_DOMAIN) ?></i>
                <?php else: ?>
                <?php echo $obj->paymentCurrency().$form->getRenderer()->renderInput($form->getElement("payment_paid"), "text") ?>
                <?php endif; ?>
                </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Discount", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php echo (!$obj->isFree() ? $obj->paymentDiscount() :  "<i>".__("not applicable", WPJB_DOMAIN)."</i>") ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Uploaded Image", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php if($obj->hasImage()): ?>
                    <a id="wpjb-image-preview" target="blank" href="<?php echo $obj->getImageUrl() ?>"class="button button-highlighted"><?php _e("preview", WPJB_DOMAIN) ?></a>
                    <a id="wpjb-image-remove" href="#"class="button button-highlighted"><?php _e("remove", WPJB_DOMAIN) ?></a>
                <?php else: ?>
                    <i><?php _e("no image uploaded", WPJB_DOMAIN) ?></i>
                <?php endif; ?>
            </td>
        </tr>

        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php _e("Job Statistics", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Page Views", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td"><?php echo $obj->stat_views ?></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Unique Views", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td"><?php echo $obj->stat_unique ?></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Applications Sent", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td"><?php echo $obj->stat_apply ?></td>
        </tr>
        <?php /*
        <tr valign="top">
            <th scope="row">Approved</th>
            <td class="wpjb-normal-td">
                <?php if($obj->is_approved): ?>
                    Yes
                <?php else: ?>
                <?php echo $form->getRenderer()->renderBox($form->getElement("is_approved"), "checkbox"); ?>
                <?php endif; ?>
            </td>
        </tr>
        */ ?>

        <?php endif; ?>
        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php _e("Company Details", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <?php echo $form->renderGroup("company"); ?>

        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php _e("Job Details", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <?php echo $form->renderGroup("job"); ?>

        <?php $group = $form->renderGroup("fields"); ?>
        <?php if($group !== null): ?>
        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php _e("Additional Fields", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <?php echo $group; ?>
        <?php endif; ?>

        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php _e("Location Details", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <?php echo $form->renderGroup("location"); ?>

        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>
<?php endif; ?>
<?php $this->_include("footer.php"); ?>