<?php $this->slot("title", __("Employer", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

    <table class="form-table">
        <tbody>

            <?php if($already_requested): ?>

            <?php elseif($request_sent): ?>
            <tr valign="top">
                <td class="wpjb-form-spacer" ><h3><?php _e("Request has been sent", WPJB_DOMAIN); ?></h3></td>
            </tr>
            <tr>
                <td class="wpjb-normal-td">
                    <div style="margin-top:10px">
                        <?php _e("Once your employer account is approved you will be notified by email.") ?>

                    </div>
                </td>
            </tr>
            <?php else: ?>
            <tr valign="top">
                <td class="wpjb-form-spacer" ><h3><?php _e("About Employer Accounts", WPJB_DOMAIN); ?></h3></td>
            </tr>
            <tr>
                <td class="wpjb-normal-td">

                    <div style="margin-top:10px">
                        <ul>
                            <li><strong><?php _e("There are two ways to get an employer account", WPJB_DOMAIN) ?></strong></li>
                            <li><?php _e("You can have your employer account created automatically when posting your first job ad.", WPJB_DOMAIN) ?></li>
                            <li><?php _e("Request employer account using button below.", WPJB_DOMAIN) ?></li>
                        </ul>
                        
                    </div>

                    <p id="wpjb-employer-actions" class="submit wpjb-import-box">
                        <form action="<?php echo $this->_url->linkTo("wpjb/employer/register"); ?>" method="post" id="">
                        <input type="hidden" name="request_employer" value="1" />
                        <input type="submit" value="Request employer account now!" id="wpjb-start-import" class="button-primary" />
                        </form>
                    </p>

                </td>
            </tr>
            <?php endif; ?>

        </tbody>
    </table>

</div>

<?php $this->_include("footer.php"); ?>