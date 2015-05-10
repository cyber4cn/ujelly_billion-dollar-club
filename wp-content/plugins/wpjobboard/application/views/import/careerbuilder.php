<?php $this->slot("title", __("CareerBuilder Import", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<form action="" method="post" enctype="multipart/form-data" id="wpjb-import-step-1">
    <input type="hidden" name="import_engine" id="import_engine" import value="careerbuilder" />
    
    <table class="form-table">
        <tbody>

        <tr valign="top">
            <td class="wpjb-form-spacer" colspan="2"><h3><?php _e("Import Information", WPJB_DOMAIN) ?></h3></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Job Country", WPJB_DOMAIN) ?></th>
            <td>
                <select name="import_country" id="import_country">
                    <option value="US"><?php _e("United States", WPJB_DOMAIN) ?></option>
                    <option value="UK"><?php _e("United Kingdom", WPJB_DOMAIN) ?></option>
                    <option value="IN"><?php _e("India", WPJB_DOMAIN) ?></option>
                    <option value="CA"><?php _e("Canada", WPJB_DOMAIN) ?></option>
                    <option value="DE"><?php _e("Germany", WPJB_DOMAIN) ?></option>
                    <option value="NL"><?php _e("Netherlands", WPJB_DOMAIN) ?></option>
                    <option value="SE"><?php _e("Sweden", WPJB_DOMAIN) ?></option>
                    <option value="ES"><?php _e("Spain", WPJB_DOMAIN) ?></option>
                    <option value="IT"><?php _e("Italy", WPJB_DOMAIN) ?></option>
                    <option value="FR"><?php _e("France", WPJB_DOMAIN) ?></option>
                    <option value="CH"><?php _e("Switzerland", WPJB_DOMAIN) ?></option>
                    <option value="GR"><?php _e("Greece", WPJB_DOMAIN) ?></option>
                    <option value="BE"><?php _e("Belgium", WPJB_DOMAIN) ?></option>
                    <option value="NO"><?php _e("Norway", WPJB_DOMAIN) ?></option>
                    <option value="CN"><?php _e("China", WPJB_DOMAIN) ?></option>
                    <option value="RO"><?php _e("Romania", WPJB_DOMAIN) ?></option>
                    <option value="IE"><?php _e("Ireland", WPJB_DOMAIN) ?></option>
                    <option value="DK"><?php _e("Denmark", WPJB_DOMAIN) ?></option>
                    <option value="PL"><?php _e("Poland", WPJB_DOMAIN) ?></option>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Job Category", WPJB_DOMAIN) ?></th>
            <td>
                <select name="import_category" id="import_category">
                    <?php foreach($category as $c): ?>
                    <option value="<?php echo $c->getId() ?>">
                        <?php echo esc_html($c->title); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <br />
                <span class="setting-description"><?php _e("Select category to which jobs will be imported", WPJB_DOMAIN) ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Job Location", WPJB_DOMAIN) ?></th>
            <td>
                <input name="import_location" id="import_location" value="" />
                <br />
                <span class="setting-description"><?php _e("Enter location: single city name, a single state name, a postal code (as in: 30092), a comma-separated city/state pair (as in: Atlanta, GA), or a latitude and longitude in decimal degree (DD) format (as in 36.7636::-119.7746).", WPJB_DOMAIN) ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Posted Within", WPJB_DOMAIN) ?></th>
            <td>
                <select name="import_posted_within" id="import_posted_within">
                    <option value="1"><?php _e("1 Day", WPJB_DOMAIN) ?></option>
                    <option value="3"><?php _e("3 Days", WPJB_DOMAIN) ?></option>
                    <option value="7"><?php _e("7 Days", WPJB_DOMAIN) ?></option>
                    <option value="30"><?php _e("30 Days", WPJB_DOMAIN) ?></option>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Keyword", WPJB_DOMAIN) ?></th>
            <td>
                <input type="text" name="import_keyword" id="import_keyword" /><br/>
                <span class="setting-description"><?php _e("Search for jobs matching this keyword", WPJB_DOMAIN) ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Max. Jobs", WPJB_DOMAIN) ?></th>
            <td>
                <select name="import_max" id="import_max">
                    <option><?php _e("10", WPJB_DOMAIN) ?></option>
                    <option><?php _e("25", WPJB_DOMAIN) ?></option>
                    <option><?php _e("50", WPJB_DOMAIN) ?></option>
                </select><br/>
                <span class="setting-description"><?php _e("Maximum number of jobs to add", WPJB_DOMAIN) ?></span>
            </td>
        </tr>
     
        </tbody>
    </table>

    <p class="submit">
    <input type="submit" value="<?php _e("Continue", WPJB_DOMAIN) ?>" class="button-primary" id="wpjb-continue" name="Submit"/>
    </p>

</form>

<form action="" method="post" id="wpjb-import-step-2">
    <table class="form-table">
        <tbody>

            <tr valign="top">
                <td class="wpjb-form-spacer" ><h3><?php _e("You are almost done!", WPJB_DOMAIN) ?></h3></td>
            </tr>
            <tr>
                <td class="wpjb-normal-td">

                    <?php _e("Job board will now search CareerBuilder for jobs that match your selection", WPJB_DOMAIN) ?>
                    <div style="margin-top:10px">
                        <?php _e("<strong>Important note:</strong> CareerBuilder sets limits on number of API calls per day, it is preferable that you do not import more then total of 50 jobs within 24 hours.", WPJB_DOMAIN) ?> 
                        <?php _e("If you fail to do that CareerBuilder might freeze your API access for 24 hours.", WPJB_DOMAIN) ?>
                    </div>

                    <center>
                    <div class="wpjb-import-box">
                        <?php _e("Jobs Found", WPJB_DOMAIN) ?>&nbsp;<span id="wpjb-import-found">0</span>.
                        <?php _e("Current Request", WPJB_DOMAIN) ?>&nbsp;<span id="wpjb-import-request">0</span>.
                        <?php _e("Imported", WPJB_DOMAIN) ?>&nbsp;<span id="wpjb-import-added">0</span>/<span id="wpjb-import-max">0</span>.
                    </div>
                    <div id="wpjb-progress-bar">
                        <div id="wpjb-progress"></div>
                    </div>
                    
                    <p id="wpjb-import-actions" class="submit wpjb-import-box">
                        <input type="submit" value="<?php _e("Go Back", WPJB_DOMAIN) ?>" id="wpjb-back-import" class="button-primary" />
                        <input type="submit" value="<?php _e("Start Import", WPJB_DOMAIN) ?>" id="wpjb-start-import" class="button-primary" />
                    </p>
                    <p id="wpjb-import-info" class="submit wpjb-import-box">
                        <?php _e("Import started, you will be informed once it will be completed.", WPJB_DOMAIN) ?>
                    </p>
                    </center>

                </td> 
            </tr>

        </tbody>
    </table>
</form>

</div>

<?php $this->_include("footer.php"); ?>