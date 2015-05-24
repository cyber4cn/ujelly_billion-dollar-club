
<div class="directory-lite edit-details">

    <?php ldl_get_header(); ?>

    <h2>Edit valuation for &ldquo;<?php echo ldl_get_value('title'); ?>&rdquo;</h2>

    <form id="submit-listing" name="submit-listing" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="action" value="edit-valuation">
        <?php echo wp_nonce_field('edit-valuation', 'nonce_field', 0, 0); ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="f_valuation"><?php _e('Valuation', 'ldd-directory-lite'); ?></label>
                        <input type="text" id="f_valuation" class="form-control" name="n_valuation" value="<?php echo ldl_get_value('valuation'); ?>" required>
                        <?php echo ldl_get_error('valuation'); ?>
                    </div>
                </div>
			</div>
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="f_product_name"><?php _e('Product_name', 'ldd-directory-lite'); ?></label>
                        <input type="text" id="f_product_name" class="form-control" name="n_product_name" value="<?php echo ldl_get_value('product_name'); ?>">
                        <?php echo ldl_get_error('product_name');?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="f_the_amount_of_financing"><?php _e('The_amount_of_financing', 'ldd-directory-lite'); ?></label>
                        <input type="text" id="f_the_amount_of_financing" class="form-control" name="n_the_amount_of_financing" value="<?php echo ldl_get_value('the_amount_of_financing'); ?>">
                        <?php echo ldl_get_error('the_amount_of_financing'); ?>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="f_the_date_of_financing"><?php _e('The_date_of_financing', 'ldd-directory-lite'); ?></label>
                        <input type="text" id="f_the_date_of_financing" class="form-control" name="n_the_date_of_financing" value="<?php echo ldl_get_value('the_date_of_financing'); ?>">
                        <?php echo ldl_get_error('the_date_of_financing'); ?>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="f_the_times_of_financing"><?php _e('The_times_of_financing', 'ldd-directory-lite'); ?></label>
                        <input type="text" id="f_the_times_of_financing" class="form-control" name="n_the_times_of_financing" value="<?php echo ldl_get_value('the_times_of_financing'); ?>">
                        <?php echo ldl_get_error('the_times_of_financing'); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php ldl_get_template_part('edit', 'submit'); ?>
    </form>

</div>
