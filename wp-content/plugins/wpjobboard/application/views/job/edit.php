<?php if($form->getObject()->getId()>0): ?>
<?php $subject = __("Edit Job | ID: {id}", WPJB_DOMAIN) ?>
<?php $this->slot("title", str_replace("{id}", $form->getObject()->getId(), $subject)); ?>
<?php else: ?>
<?php $this->slot("title", __("Add Job", WPJB_DOMAIN)); ?>
<?php endif; ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/job"); ?>"class="button button-highlighted">
        <?php _e("Go back", WPJB_DOMAIN) ?>
    </a>
    &nbsp;
    <?php if($form->getObject()->getId()): ?>
    <a href="<?php echo wpjb_link_to("job", $form->getObject()) ?>"class="button button-highlighted">
        <?php _e("View job", WPJB_DOMAIN) ?>
    </a>
    <?php endif; ?>
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
            <th scope="row"><?php _e("Posted by", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
            <?php if($form->getObject()->employer_id > 0): ?>
                <?php $item = new Wpjb_Model_Employer($form->getObject()->employer_id) ?>
                <a href="<?php echo $this->_url->linkTo("wpjb/employers", "edit/id/".$item->getId()); ?>">
                    <?php echo (strlen($item->company_name)) ? esc_html($item->company_name) : "-" ?>
                    (ID: <?php echo $item->getId() ?>)
                </a>
            <?php else: ?>
                <?php _e("Anonymous", WPJB_DOMAIN) ?>
            <?php endif; ?>
            </td>
        </tr>
        <?php if($form->getObject()->employer_id > 0): ?>
        <?php $repr = new Wpjb_Model_User($item->user_id) ?>
        <tr valign="top">
            <th scope="row"><?php _e("Representative", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <a href="user-edit.php?user_id=<?php echo $repr->getId() ?>"><?php echo esc_html($repr->display_name." (ID: ".$repr->getId().")") ?></a>
            </td>
        <?php endif; ?>
        <tr valign="top">
            <th scope="row"><?php _e("Created At", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td"><?php echo date("Y-m-d", strtotime($form->getObject()->job_created_at)) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Expires", WPJB_DOMAIN) ?></th>
            <td class="wpjb-normal-td">
                <?php if($obj->job_visible>0): ?>
                <?php echo date("Y-m-d", strtotime($obj->expiresAt()))  ?> (<?php _e("Number of days visible", WPJB_DOMAIN) ?>: <?php echo $obj->job_visible ?>)
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
                    <a id="wpjb-image-remove" href="#"class="button button-highlighted">remove</a>
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

        <?php endif; ?>

        <?php 
            foreach($form->getFinalScheme() as $key => $formPart):

            if(!count($formPart["element"]) || $key == "unknown") continue;
        ?>

        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php echo esc_html($formPart["title"]) ?></h3></td>
        </tr>
        <?php echo $form->renderGroup($key); ?>


        <?php endforeach; ?>

        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>

<?php $this->_include("footer.php"); ?>
