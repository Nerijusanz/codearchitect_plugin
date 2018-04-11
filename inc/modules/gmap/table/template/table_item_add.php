<?php
/**
 * @package Codearchitect
 */

use CA_Inc\modules\gmap\table\TableSetup;

echo TableSetup::page_link();

$table_name = TableSetup::$table_name;

echo '<form method="post" action="'.admin_url('admin-post.php').'">';

    wp_nonce_field($table_name.'_add_action',$table_name.'_add_nonce');

    echo '<input type="hidden" name="action" value="'.$table_name.'_form_add" />';?>

        <table class="form-table">

            <tbody>

                <tr>
                    <th scope="row"><?php _e('Location title',PLUGIN_DOMAIN);?></th>
                    <td><?php echo TableSetup::field_item_title(); ?></td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Location latitude',PLUGIN_DOMAIN);?></th>
                    <td><?php echo TableSetup::field_item_lat(); ?></td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Location longitude',PLUGIN_DOMAIN);?></th>
                    <td><?php echo TableSetup::field_item_long(); ?></td>
                </tr>

            </tbody>

        </table>
    <?php
    echo '<p><input type="submit" name="'.$table_name.'form_add_submit" class="button button-primary" value="'. __('Save Changes',PLUGIN_DOMAIN).'" /></p>';

echo '</form>';

?>