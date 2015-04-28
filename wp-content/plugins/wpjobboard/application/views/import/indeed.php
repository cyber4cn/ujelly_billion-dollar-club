<?php $this->slot("title", __("Indeed Import", WPJB_DOMAIN)); ?>
<?php $this->_include("header.php"); ?>

<?php if(!$isConf): ?>
<div class="updated fade below-h2">
    <p>
        <strong>
        <?php _e("Before using Indeed import you need to ", WPJB_DOMAIN) ?>
        <a href="https://ads.indeed.com/jobroll/"><?php _e("claim your Indeed Publisher Key", WPJB_DOMAIN) ?></a>
        <?php _e("and enter your API key in ", WPJB_DOMAIN) ?>
        <a href="admin.php?page=wpjb/config&action=edit/section/integration"><?php _e("External Integrations Configuration", WPJB_DOMAIN) ?></a>
        </strong>
    </p>
</div>
<?php else: ?>
<form action="" method="post" enctype="multipart/form-data" id="wpjb-import-step-1">
    <input type="hidden" name="import_engine" id="import_engine" value="indeed" />
    
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
                    <option value="AR"><?php _e("Argentina", WPJB_DOMAIN) ?></option>
                    <option value="AU"><?php _e("Australia", WPJB_DOMAIN) ?></option>
                    <option value="AT"><?php _e("Austria", WPJB_DOMAIN) ?></option>
                    <option value="BH"><?php _e("Bahrain", WPJB_DOMAIN) ?></option>
                    <option value="BE"><?php _e("Belgium", WPJB_DOMAIN) ?></option>
                    <option value="BR"><?php _e("Brazil", WPJB_DOMAIN) ?></option>
                    <option value="CA"><?php _e("Canda", WPJB_DOMAIN) ?></option>
                    <option value="CL"><?php _e("Chile", WPJB_DOMAIN) ?></option>
                    <option value="CN"><?php _e("China", WPJB_DOMAIN) ?></option>
                    <option value="CO"><?php _e("Colombia", WPJB_DOMAIN) ?></option>
                    <option value="CZ"><?php _e("Czech Republic", WPJB_DOMAIN) ?></option>
                    <option value="DK"><?php _e("Denmark", WPJB_DOMAIN) ?></option>
                    <option value="FI"><?php _e("Finland", WPJB_DOMAIN) ?></option>
                    <option value="FR"><?php _e("France", WPJB_DOMAIN) ?></option>
                    <option value="DE"><?php _e("Germany", WPJB_DOMAIN) ?></option>
                    <option value="GR"><?php _e("Greece", WPJB_DOMAIN) ?></option>
                    <option value="HK"><?php _e("Hong Kong", WPJB_DOMAIN) ?></option>
                    <option value="HU"><?php _e("Hungary", WPJB_DOMAIN) ?></option>
                    <option value="IN"><?php _e("India", WPJB_DOMAIN) ?></option>
                    <option value="ID"><?php _e("Indonesia", WPJB_DOMAIN) ?></option>
                    <option value="IE"><?php _e("Ireland", WPJB_DOMAIN) ?></option>
                    <option value="IL"><?php _e("Israel", WPJB_DOMAIN) ?></option>
                    <option value="IT"><?php _e("Italy", WPJB_DOMAIN) ?></option>
                    <option value="JP"><?php _e("Japan", WPJB_DOMAIN) ?></option>
                    <option value="KR"><?php _e("Korea", WPJB_DOMAIN) ?></option>
                    <option value="KW"><?php _e("Kuwait", WPJB_DOMAIN) ?></option>
                    <option value="LU"><?php _e("Luxembourg", WPJB_DOMAIN) ?></option>
                    <option value="MY"><?php _e("Malaysia", WPJB_DOMAIN) ?></option>
                    <option value="MX"><?php _e("Mexico", WPJB_DOMAIN) ?></option>
                    <option value="NL"><?php _e("Netherlands", WPJB_DOMAIN) ?></option>
                    <option value="NZ"><?php _e("New Zeland", WPJB_DOMAIN) ?></option>
                    <option value="NO"><?php _e("Norway", WPJB_DOMAIN) ?></option>
                    <option value="OM"><?php _e("Oman", WPJB_DOMAIN) ?></option>
                    <option value="PK"><?php _e("Pakistan", WPJB_DOMAIN) ?></option>
                    <option value="PE"><?php _e("Peru", WPJB_DOMAIN) ?></option>
                    <option value="PH"><?php _e("Philippines", WPJB_DOMAIN) ?></option>
                    <option value="PL"><?php _e("Poland", WPJB_DOMAIN) ?></option>
                    <option value="PT"><?php _e("Portugal", WPJB_DOMAIN) ?></option>
                    <option value="QA"><?php _e("Qatar", WPJB_DOMAIN) ?></option>
                    <option value="RO"><?php _e("Romania", WPJB_DOMAIN) ?></option>
                    <option value="RO"><?php _e("Russia", WPJB_DOMAIN) ?></option>
                    <option value="SA"><?php _e("Saudi Arabia", WPJB_DOMAIN) ?></option>
                    <option value="SG"><?php _e("Singapore", WPJB_DOMAIN) ?></option>
                    <option value="ZA"><?php _e("South Africa", WPJB_DOMAIN) ?></option>
                    <option value="ES"><?php _e("Spain", WPJB_DOMAIN) ?></option>
                    <option value="SE"><?php _e("Sweden", WPJB_DOMAIN) ?></option>
                    <option value="CH"><?php _e("Switzerland", WPJB_DOMAIN) ?></option>
                    <option value="TW"><?php _e("Taiwan", WPJB_DOMAIN) ?></option>
                    <option value="TR"><?php _e("Turkey", WPJB_DOMAIN) ?></option>
                    <option value="AE"><?php _e("United Arab Emirates", WPJB_DOMAIN) ?></option>
                    <option value="GB"><?php _e("United Kingdom", WPJB_DOMAIN) ?></option>
                    <option value="VE"><?php _e("Venezuela", WPJB_DOMAIN) ?></option>
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

                    <?php _e("Job board will now search Indeed for jobs that match your selection", WPJB_DOMAIN) ?>
                    <div style="margin-top:10px">
                        <?php _e("<strong>Important note:</strong> Indeed sets limits on number of API calls per day, it is preferable that you do not import more then total of 50 jobs within 24 hours.", WPJB_DOMAIN) ?> 
                        <?php _e("If you fail to do that Indeed might freeze your API access for 24 hours.", WPJB_DOMAIN) ?>
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
<?php endif; ?>
</div>

<?php $this->_include("footer.php"); ?>