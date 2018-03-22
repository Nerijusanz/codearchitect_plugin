<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\cpt\template\table;

use CA_Inc\modules\cpt\CptSetup;
use CA_Inc\modules\cpt\CptCallback;
?>

<h2>Item delete</h2>

<?php echo CptSetup::link_to_cpt_page();?>

    <?php $module = CptSetup::$module;?>

    <?php echo '<form method="post" action="'.admin_url('admin-post.php').'">';?>

    <?php wp_nonce_field($module.'_module_form_delete_action',$module.'_module_form_delete_nonce');?>

    <?php echo '<input type="hidden" name="action" value="'.$module.'_module_form_delete" />';?>

    <?php if(isset($cpt_module)) CptCallback::field_cpt_module_id( esc_attr($cpt_module['module_id']) ); ?>

    <table class="form-table">

        <tbody>

            <tr>
                <th scope="row"><?php _e('Module name',PLUGIN_DOMAIN);?></th>
                <td><span><?php if(isset($cpt_module)) echo esc_html($cpt_module['module_name']);?></span></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Singular name',PLUGIN_DOMAIN);?></th>
                <td><span><?php if(isset($cpt_module)) echo esc_html($cpt_module['singular_name']);?></span></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Plural name',PLUGIN_DOMAIN);?></th>
                <td><span><?php if(isset($cpt_module)) echo esc_html($cpt_module['plural_name']);?></span></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Public status',PLUGIN_DOMAIN);?></th>
                <?php if(isset($cpt_module)){
                    $public_status = ($cpt_module['public_status']==1)?'yes':'no';
                } ?>
                <td><span><?php if(isset($public_status)) esc_html_e($public_status); ?></span></td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Archive status',PLUGIN_DOMAIN);?></th>
                <?php if(isset($cpt_module)){
                    $archive_status = ($cpt_module['archive_status']==1)?'yes':'no';
                } ?>
                <td><span><?php if(isset($archive_status)) esc_html_e($archive_status);?></span></td>
            </tr>

        </tbody>

    </table>

    <?php echo '<p><input type="submit" name="'.$module.'_module_form_delete_submit" class="button button-primary" value="'. __('Delete module',PLUGIN_DOMAIN).'" /></p>';?>

</form>

