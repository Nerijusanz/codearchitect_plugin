<?php
/**
 * @package Codearchitect
 */

use CA_Inc\modules\gmap\table\TableSetup;

?>

<h2>Item edit</h2>

<?php echo TableSetup::page_link();?>

<?php $table = TableSetup::$table;?>

<?php echo '<form method="post" action="'.admin_url('admin-post.php').'">';?>

    <?php wp_nonce_field($table.'_edit_action',$table.'_edit_nonce');?>

    <?php echo '<input type="hidden" name="action" value="'.$table.'_form_edit" />';?>

    <?php echo TableSetup::field_item_id($item['id']);?>


    <table class="form-table">

        <tbody>

            <tr>
                <th scope="row"><?php _e('Location title',PLUGIN_DOMAIN);?></th>
                <td><?php echo TableSetup::field_item_title($item['title']); ?></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Location latitude',PLUGIN_DOMAIN);?></th>
                <td><?php echo TableSetup::field_item_lat($item['lat']); ?></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Location longitude',PLUGIN_DOMAIN);?></th>
                <td><?php echo TableSetup::field_item_long($item['long']); ?></td>
            </tr>

        </tbody>

    </table>

    <?php echo '<p><input type="submit" name="'.$table.'_form_edit_submit" class="button button-primary" value="'. __('Save Changes',PLUGIN_DOMAIN).'" /></p>';?>

</form>