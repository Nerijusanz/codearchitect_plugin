<?php
/**
 * @package Codearchitect
 */

use CA_Inc\modules\gmap\table\TableSetup;

?>

<h2>Item delete</h2>

<?php echo TableSetup::page_link();?>

<?php $table_name = TableSetup::$table_name;?>

<?php echo '<form method="post" action="'.admin_url('admin-post.php').'">';?>

<?php wp_nonce_field($table_name.'_delete_action',$table_name.'_delete_nonce');?>

<?php echo '<input type="hidden" name="action" value="'.$table_name.'_form_delete" />';?>

<?php echo TableSetup::field_item_id($item['id']);?>


<table class="form-table">

    <tbody>

        <tr>
            <th scope="row"><?php _e('Location title',PLUGIN_DOMAIN);?></th>
            <td><?php echo $item['title']; ?></td>
        </tr>

        <tr>
            <th scope="row"><?php _e('Location latitude',PLUGIN_DOMAIN);?></th>
            <td><?php echo $item['lat']; ?></td>
        </tr>

        <tr>
            <th scope="row"><?php _e('Location longitude',PLUGIN_DOMAIN);?></th>
            <td><?php echo $item['long']; ?></td>
        </tr>

    </tbody>

</table>

<?php echo '<p><input type="submit" name="'.$table_name.'_form_delete_submit" class="button button-primary" value="'. __('Delete',PLUGIN_DOMAIN).'" /></p>';?>

</form>

