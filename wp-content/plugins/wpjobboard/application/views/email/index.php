<?php $this->slot("title", __("Email Templates", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<form method="post" action="" id="posts-filter">
<input type="hidden" name="action" id="wpjb-action-holder" value="-1" />

<div class="tablenav">



<div class="clear"/>&nbsp;</div>

<table cellspacing="0" class="widefat post fixed">
    <?php foreach(array("thead", "tfoot") as $tx): ?>
    <<?php echo $tx; ?>>
        <tr>
            <th style="width:25%" class="" scope="col"><?php _e("Mail Title", WPJB_DOMAIN) ?></th>
            <th style="width:30%" class="" scope="col"><?php _e("Sent When", WPJB_DOMAIN) ?></th>
            <th style="width:20%" class="column-icon" scope="col"><?php _e("Mail From", WPJB_DOMAIN) ?></th>
        </tr>
    </<?php echo $tx; ?>>
    <?php endforeach; ?>

    <tbody>
        <?php $i = 0; ?>
        <?php foreach($data as $j => $group): ?>
        <tr valign="top" class="author-self status-publish iedit">
            <td colspan="3"><h3><b><?php echo $desc[$j] ?></b></h3></td>
        </tr>
        <?php $i++; ?>
        <?php foreach($group as $item): ?>
	<tr valign="top" class="<?php if($i%2==0 || true): ?>alternate <?php endif; ?>  author-self status-publish iedit">
            <td class="post-title column-title">
                <strong><a title='<?php _e("Edit", WPJB_DOMAIN) ?>  "(<?php esc_attr_e($item->mail_title) ?>)"' href="<?php echo $this->_url->linkTo("wpjb/email", "edit/id/".$item->getId()); ?>" class="row-title"><?php esc_html_e($item->mail_title) ?></a></strong>
            </td>
            <td class=""><?php esc_html_e($item->sent_when) ?></td>
            <td class="author column-author"><?php esc_html_e($item->mail_from) ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">

</div>


</form>

<?php $this->_include("footer.php"); ?>