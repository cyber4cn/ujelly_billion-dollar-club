<?php $title = __("Edit Email Template | ID: {id}", WPJB_DOMAIN); ?>
<?php $this->slot("title", str_replace("{id}", $form->getObject()->getId(), $title)); ?>
<?php $this->_include("header.php"); ?>

<div class="wpjb-buttons">
    <a href="<?php echo $this->_url->linkTo("wpjb/email"); ?>"class="button button-highlighted">
        <?php _e("Go back", WPJB_DOMAIN) ?>
    </a>
</div>

<form action="" method="post" class="wpjb-form">
    <table class="form-table">
        <tbody>
        <?php echo $form->render(); ?>
        </tbody>
    </table>

    <table class="wpjb-email">
        <tbody>
            <?php if(!in_array($id, array(11,12))): ?>
            <tr><th colspan="2"><?php _e("General template variables", WPJB_DOMAIN) ?></th></tr>
            <tr><td><code>{$id}</code>: <?php _e("Internal ID assigned to the job posting", WPJB_DOMAIN) ?></td><td><code>{$created}</code>: <?php _e("Date when job posting was created", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$visible}</code>: <?php _e("How long (in days) job posting will be visible", WPJB_DOMAIN) ?></td><td><code>{$price}</code>: <?php _e("Job posting price", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$paid}</code>: <?php _e("How much was already paid", WPJB_DOMAIN) ?></td><td><code>{$promo_code}</code>: <?php _e("Used promo code", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$discount}</code>: <?php _e("Value (in USD) of the discount", WPJB_DOMAIN) ?></td><td><code>{$company}</code>: <?php _e("Name of the company that posted a job", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$location}</code>: <?php _e("Company location", WPJB_DOMAIN) ?></td><td><code>{$email}</code>: <?php _e("Company contact eMail address", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$position_title}</code>: <?php _e("Title of the job posting", WPJB_DOMAIN) ?></td><td><code>{$listing_type}</code>: <?php _e("Selected type of listing", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$category}</code>: <?php _e("Selected category", WPJB_DOMAIN) ?></td><td><code>{$active}</code>: <?php _e("Is listing active (Either: active or inactive)", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$url}</code>: <?php _e("URL to the job posting", WPJB_DOMAIN) ?></td><td><code>{$pay_paypal}</code>: <?php _e("Pay by PayPal URL. [For future use]", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$expiration}</code>: <?php _e("Lisitng expiration date", WPJB_DOMAIN) ?></td><td> </td></tr>
            <?php endif; ?>
            
            <?php if($id == 6): ?>
            <tr><th colspan="2"><?php _e("\"Apply\" form variables", WPJB_DOMAIN) ?></th></tr>
            <tr><td><code>{$applicant_name}</code>: <?php _e("Applicant name the \"Apply\" form", WPJB_DOMAIN) ?></td><td><code>{$applicant_email}</code>: <?php _e("Applicant email address", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$applicant_cv}</code>: <?php _e("Applicant CV text", WPJB_DOMAIN) ?></td></tr>
            <?php elseif($id == 7): ?>
            <tr><th colspan="2"><?php _e("Current template variables", WPJB_DOMAIN) ?></th></tr>
            <tr><td><code>{$alert_keyword}</code>: <?php _e("Title from the \"Apply\" form", WPJB_DOMAIN) ?></td><td><code>{$alert_unsubscribe_url}</code>: <?php _e("Alert unsubscribe URL", WPJB_DOMAIN) ?></td></tr>
            <?php endif; ?>
            
            <?php if($id == 11): ?>
            <tr><th colspan="2"><?php _e("Current template variables", WPJB_DOMAIN) ?></th></tr>
            <tr><td><code>{$id}</code>: <?php _e("Candidate ID", WPJB_DOMAIN) ?></td><td><code>{$email}</code>: <?php _e("Candidate email address", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$resume_admin_url}</code>: <?php _e("Resume edition URL in wp-admin", WPJB_DOMAIN) ?></td><td><code>{$title}</code>: <?php _e("Professional headline", WPJB_DOMAIN) ?></td></tr>
            <?php endif; ?>
            
            <?php if($id == 12): ?>
            <tr><th colspan="2"><?php _e("Current template variables", WPJB_DOMAIN) ?></th></tr>
            <tr><td><code>{$id}</code>: <?php _e("Company ID", WPJB_DOMAIN) ?></td><td><code>{$company_website}</code>: <?php _e("Company website URL", WPJB_DOMAIN) ?></td></tr>
            <tr><td><code>{$company_admin_url}</code>: <?php _e("Company edition URL in wp-admin", WPJB_DOMAIN) ?></td><td><code>{$company_name}</code>: <?php _e("Company name", WPJB_DOMAIN) ?></td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Save Changes", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>

</form>

<?php $this->_include("footer.php"); ?>