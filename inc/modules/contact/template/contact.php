<?php
/**
 * @package Codearchitect
 */
namespace CA_Inc\modules\contact\template;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\modules\contact\ContactSetup;

?>

<div class="page">
<?php
    echo ModulesSetup::generate_modules_top_navigation();

    $module = ContactSetup::$module;

    echo '<form method="post" action="'.admin_url('admin-post.php').'">';

        wp_nonce_field($module.'_module_form_add_action',$module.'_module_form_add_nonce');

        echo '<input type="hidden" name="action" value="'.$module.'_module_form_add" />';

        do_settings_sections( ContactSetup::$module_slug );

        echo '<p><input type="submit" name="'.$module.'_module_form_add_submit" class="button button-primary" value="'. __('Save Changes',PLUGIN_DOMAIN).'" /></p>';

    echo '</form>';

?>
</div>


