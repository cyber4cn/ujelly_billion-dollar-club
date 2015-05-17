<div class="container-fluid">
	<?php if (ldl()->get_option('submit_intro')): ?>
    <div class="row">
		<div class="col-md-12">
            <?php echo wpautop(ldl()->get_option('submit_intro')); ?>
		</div>
	</div>
    <?php endif; ?>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label" for="f_title"><?php _e('Title', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_title" class="form-control" name="n_title" value="<?php echo ldl_get_value('title'); ?>" required>
				<?php echo ldl_get_error('title'); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label" for="f_category"><?php _e('Category', 'ldd-directory-lite'); ?></label>
				<?php ldl_submit_categories_dropdown( ldl_get_value('category'), 'category' ); ?>
				<?php echo ldl_get_error('category'); ?>
			</div>
		</div>
	</div>
    
    
    <div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for="f_valuation"><?php _e('Valuation', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_valuation" class="form-control" name="n_valuation" value="<?php echo ldl_get_value('valuation'); ?>" required>
				<?php echo ldl_get_error('valuation'); ?>
				<p class="help-block"><?php _e('Please provide the lastest valuation of your company.', 'ldd-directory-lite'); ?></p>
			</div>
		</div>
	</div>
     <div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for="f_Productname"><?php _e('Product_name', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_product_name" class="form-control" name="n_product_name" value="<?php echo ldl_get_value('product_name'); ?>" required>
				<?php echo ldl_get_error('product_name'); ?>
				<p class="help-block"><?php _e('Please provide product name of your company.', 'ldd-directory-lite'); ?></p>
			</div>
		</div>
	</div>
    <div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for=""><?php _e('The_amount_of_financing', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_the_amount_of_financing" class="form-control" name="n_the_amount_of_financing" value="<?php echo ldl_get_value('the_amount_of_financing'); ?>">
                <?php echo ldl_get_error('the_amount_of_financing'); ?>
				<p class="help-block"><?php _e('Please provide the_amount_of_financing of your company.', 'ldd-directory-lite'); ?></p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for=""><?php _e('The_date_of_financing', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_the_date_of_financing" class="form-control" name="n_the_date_of_financing" value="<?php echo ldl_get_value('the_date_of_financing'); ?>">
                <?php echo ldl_get_error('the_date_of_financing'); ?>
				<p class="help-block"><?php _e('Please provide the_date_of_financing of your company.', 'ldd-directory-lite'); ?></p>
			</div>
		</div>
	</div>
    <div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for=""><?php _e('The_times_of_financing', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_the_times_of_financing" class="form-control" name="n_the_times_of_financing" value="<?php echo ldl_get_value('the_times_of_financing'); ?>">
                <?php echo ldl_get_error('the_times_of_financing'); ?>
				<p class="help-block"><?php _e('Please provide the_times_of_financing of your company.', 'ldd-directory-lite'); ?></p>
			</div>
		</div>
		
	</div>
    
    
    
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for="f_logo"><?php _e('Logo', 'ldd-directory-lite'); ?></label>
				<input type="file" id="f_logo" class="form-control" name="n_logo">
				<?php echo ldl_get_error('category'); ?>
			</div>
		</div>
	</div>
	<div class="row bump-down">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for="f_description"><?php _e('Description', 'ldd-directory-lite'); ?></label>
				<textarea id="f_description" class="form-control" name="n_description" rows="5" required><?php echo ldl_get_value('description'); ?></textarea>
				<?php echo ldl_get_error('description'); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label" for="f_summary"><?php _e('Summary', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_summary" class="form-control" name="n_summary" value="<?php echo ldl_get_value('summary'); ?>" required>
				<?php echo ldl_get_error('summary'); ?>
				<p class="help-block"><?php _e('Please provide a short summary of your listing that will appear in search results.', 'ldd-directory-lite'); ?></p>
			</div>
		</div>
	</div>
</div>
