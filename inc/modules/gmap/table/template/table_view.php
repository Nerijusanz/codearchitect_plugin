<?php

use CA_Inc\modules\gmap\Setup;
use CA_Inc\modules\gmap\table\Table;

$module = Setup::$module;


echo '<form method="post" action="'.admin_url('admin-post.php').'">';

    wp_nonce_field($module.'_module_form_add_action',$module.'_module_form_add_nonce');

    echo '<input type="hidden" name="action" value="'.$module.'_module_form_add" />';

    do_settings_sections( Setup::$module_slug );



    echo '<p><input type="submit" name="'.$module.'_module_form_add_submit" class="button button-primary" value="'.__('Save Changes',PLUGIN_DOMAIN).'" /></p>';

    echo '</form>';
?>

<?php Table::generate_table();?>