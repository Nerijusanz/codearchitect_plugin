<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\cpt\template\table;

use CA_Inc\modules\cpt\Setup;
use CA_Inc\modules\cpt\Callback;
?>

<h2>Item edit</h2>

<?php echo Setup::link_to_cpt_page();?>

<?php $module = Setup::$module;?>

<?php echo '<form method="post" action="'.admin_url('admin-post.php').'">';?>

    <?php wp_nonce_field($module.'_module_form_edit_action',$module.'_module_form_edit_nonce');?>

    <?php echo '<input type="hidden" name="action" value="'.$module.'_module_form_edit" />';?>

    <?php if(isset($cpt_module)) Callback::field_cpt_module_id($cpt_module['module_id']);?>

    <table class="form-table">

        <tbody>

            <tr>
                <th scope="row"><?php _e('Module name',PLUGIN_DOMAIN);?></th>
                <td><?php if(isset($cpt_module)) echo esc_html($cpt_module['module_name']);?></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Singular name',PLUGIN_DOMAIN);?></th>
                <td><?php if(isset($cpt_module)) Callback::field_singular_name( esc_attr($cpt_module['singular_name']));?></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Plural name',PLUGIN_DOMAIN);?></th>
                <td><?php if(isset($cpt_module)) Callback::field_plural_name( esc_attr($cpt_module['plural_name']));?>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Public status',PLUGIN_DOMAIN);?></th>
                <td><?php
                    $value = ( $cpt_module['public_status']==1)?1:0;
                    Callback::field_public_status( esc_attr($value));
                    ?>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Archive status',PLUGIN_DOMAIN);?></th>
                <td><?php
                    $value = ($cpt_module['archive_status']==1)?1:0;
                    Callback::field_archive_status( esc_attr($value));
                    ?>
                </td>
            </tr>

        </tbody>

    </table>

    <?php echo '<p><input type="submit" name="'.$module.'_module_form_edit_submit" class="button button-primary" value="'. __('Save Changes',PLUGIN_DOMAIN).'" /></p>';?>

</form>