<?php $this->slot("title", __("XML Import", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<form action="" method="post" enctype="multipart/form-data">
    <table class="form-table">
        <tbody>
            
        <tr valign="top">
            <th scope="row"><?php _e("Import file", WPJB_DOMAIN) ?></th>
            <td>
                <input type="file" name="file" id="file" />
                <br />
                <span class="setting-description">
                    <?php _e("Select a file that follows", WPJB_DOMAIN) ?>
                    <a href="http://kb.wpjobboard.net/xml-import/"><?php _e("WPJobBoard import scheme.", WPJB_DOMAIN) ?></a>
                </span>
            </td>
        </tr>
        </tbody>
    </table>
    
    <p class="submit">
    <input type="submit" value="<?php _e("Upload", WPJB_DOMAIN) ?>" class="button-primary" name="Submit"/>
    </p>
    
</form>



</div>

<?php $this->_include("footer.php"); ?>