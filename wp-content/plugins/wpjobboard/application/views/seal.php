<?php $this->slot("title", "License Error"); ?>
<?php $this->_include("header.php"); ?>

<div class="license_err">
<img src="<?php echo site_url()."/wp-content/plugins/wpjobboard".Wpjb_List_Path::getRawPath("admin_public") ?>/char.png" alt="" />

<?php if($Wpjb == -3): ?>
<span>This copy of WPJobBoard is registered to <em><?php echo $domain ?></em> and cannot be used under current domain (<em><?php echo site_url() ?></em>).</span>
<h3>What Now?</h3>
<p>
    If this is your development server you can still use WPJobBoard here as long as your WordPress installation directory contains your selected domain name.
</p>
<p>
    For example, you registered the plugin for domain <em><?php echo $domain ?></em>, in that case on http://localhost you need to install WordPress at http://localhost/<?php echo $domain ?>/ where <?php echo $domain ?> is a directory.
</p>
<h3>Any other options?</h3>
<span>
    If you would like to use WPJobBoard under different domain please contact support at <a href="mailto:support@wpjobboard.net">support@wpjobboard.net</a>.
</span>
<?php else: ?>
<span>License is invalid or does not exist.</span>
<?php endif; ?>
</div>