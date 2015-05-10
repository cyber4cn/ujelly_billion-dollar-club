<div id="wpjb-main" class="wpjb-page-preview">

    <?php wpjb_flash(); ?>

    <?php if(wpjb_user_can_post_job()): ?>
    <?php wpjb_add_job_steps(); ?>
    <h2><?php esc_html_e($job->job_title) ?></h2>
    <?php wpjb_job_template(); ?>

    <div style="text-align:center">
        <h3>
            <a href="<?php echo wpjb_link_to("step_add") ?>">&#171; <?php _e("Edit Listing", WPJB_DOMAIN) ?></a> |
            <a href="<?php echo wpjb_link_to("step_save"); ?>"><?php _e("Publish Listing", WPJB_DOMAIN) ?> &raquo;</a>
        </h3>
    </div>
    <?php endif; ?>

</div>
