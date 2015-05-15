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
				<label class="control-label" for="f_Productname"><?php _e('Product name', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_Productname" class="form-control" name="n_Productname" value="<?php echo ldl_get_value('Productname'); ?>" required>
				<?php echo ldl_get_error('Productname'); ?>
				<p class="help-block"><?php _e('Please provide product name of your company.', 'ldd-directory-lite'); ?></p>
			</div>
		</div>
	</div>
    <div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label" for=""><?php _e('The amount of financing', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_contact_financing" class="form-control" name="n_contact_financing" value="<?php echo ldl_get_value('contact_financing'); ?>">
                <?php echo ldl_get_error('contact_financing'); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label" for=""><?php _e('The date of financing', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_contact_financingdate" class="form-control" name="n_contact_financingdate" value="<?php echo ldl_get_value('contact_financingdate'); ?>">
                <?php echo ldl_get_error('contact_financingdate'); ?>
			</div>
		</div>
	</div>
    
    <div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label" for=""><?php _e('The times of financing', 'ldd-directory-lite'); ?></label>
				<input type="text" id="f_contact_financingtimes" class="form-control" name="n_contact_financingtimes" value="<?php echo ldl_get_value('contact_financingtimes'); ?>">
                <?php echo ldl_get_error('contact_financingtimes'); ?>
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
