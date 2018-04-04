<?php
/**
 * @package Codearchitect
 */
namespace CA_Inc\modules\contact\template;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\modules\contact\ContactSetup;
use CA_Inc\modules\contact\ContactCallback;

?>

<div class="page">

<?php
    echo ModulesSetup::generate_modules_top_navigation();

    $module = ContactSetup::$module;


    printf('<h2>%s</h2>',
        __('Contact settings',PLUGIN_DOMAIN)
        );

    echo '<form method="post" action="'.admin_url('admin-post.php').'">';

        wp_nonce_field($module.'_module_form_add_action',$module.'_module_form_add_nonce');

        echo '<input type="hidden" name="action" value="'.$module.'_module_form_add" />';
?>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">

            <a class="nav-item nav-link active" id="nav-company-tab" data-toggle="tab" href="#nav-company" role="tab" aria-controls="nav-company" aria-selected="true"><?php _e('General',PLUGIN_DOMAIN);?></a>
            <a class="nav-item nav-link" id="nav-bank-tab" data-toggle="tab" href="#nav-bank" role="tab" aria-controls="nav-bank" aria-selected="false"><?php _e('Bank',PLUGIN_DOMAIN);?></a>

        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade active in" id="nav-company" role="tabpanel" aria-labelledby="nav-company-tab">

            <table class="form-table">

                <tbody>

                    <tr>
                        <th scope="row"><?php _e('Company name',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_company_name();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Company Address',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_company_address();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Company code',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_company_code();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php printf(__('%s tax code',PLUGIN_DOMAIN),'PVM')?></th>
                        <td><?php ContactCallback::field_company_pvm_code();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Company phone/fax',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_company_phone_fax();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Company mobile',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_company_mobile();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Company email',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_company_email();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Company working hours',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_company_working_hours();?></td>
                    </tr>

                </tbody>

            </table>

        </div><!--tab-pane-->

        <div class="tab-pane fade" id="nav-bank" role="tabpanel" aria-labelledby="nav-bank-tab">

            <table class="form-table">

                <tbody>

                    <tr>
                        <th scope="row"><?php _e('Bank name',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_bank_name();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Bank address',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_bank_address();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Bank code',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_bank_code();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php printf(__('Bank %s code',PLUGIN_DOMAIN),'SWIFT/BIC')?></th>
                        <td><?php ContactCallback::field_bank_swift_bic_code();?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Bank account number',PLUGIN_DOMAIN);?></th>
                        <td><?php ContactCallback::field_bank_account_number();?></td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>
<?php

    //do_settings_sections( ContactSetup::$module_slug );

    echo '<p><input type="submit" name="'.$module.'_module_form_add_submit" class="button button-primary" value="'. __('Save Changes',PLUGIN_DOMAIN).'" /></p>';

echo '</form>';

?>
</div>


