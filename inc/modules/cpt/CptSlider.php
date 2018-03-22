<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\cpt;

use CA_Inc\setup\Settings;

class CptSlider {


    public function __construct(){

        add_action('init', array($this, 'init_custom_post_type'));
    }

    public function init_custom_post_type(){

        if( isset(Settings::$plugin_db['modules']['cpt']['modules']) ):   //if cpt modules list not empty;

            foreach(Settings::$plugin_db['modules']['cpt']['modules'] as $module):

                $custom_post_type = $module['module_name'];
                $singular_name = $module['singular_name'];
                $plural_name = $module['plural_name'];

                $this->register_custom_post_type($custom_post_type,$singular_name,$plural_name);

            endforeach;

        endif;

    }


    public function register_custom_post_type($custom_post_type,$singular_name,$plural_name)
    {

        $labels = array(
            'name'               => $plural_name,   // _x( $plural_name, 'post type general name',PLUGIN_DOMAIN ),
            'singular_name'      => $singular_name, // _x( $singular_name, 'post type singular name',PLUGIN_DOMAIN ),
            'menu_name'          => $plural_name,   //_x( $plural_name, 'admin menu',PLUGIN_DOMAIN ),
            'name_admin_bar'     => $singular_name, //_x( $singular_name, 'add new on admin bar',PLUGIN_DOMAIN ),
            'add_new'            => _x( 'Add New', 'Post type',PLUGIN_DOMAIN ),
            'add_new_item'       => __( 'Add New',PLUGIN_DOMAIN ),
            'new_item'           => sprintf(__('New Item %s',PLUGIN_DOMAIN),$singular_name),// __( 'New item'.$singular_name,PLUGIN_DOMAIN ),
            'edit_item'          => __( 'Edit item',PLUGIN_DOMAIN ),
            'view_item'          => __( 'View item',PLUGIN_DOMAIN ),
            'view_items'         => __( 'View items',PLUGIN_DOMAIN ),
            'all_items'          => __( 'All items',PLUGIN_DOMAIN ),
            'search_items'       => __( 'Search',PLUGIN_DOMAIN ),
            'parent_item_colon'  => __( 'Parent',PLUGIN_DOMAIN ),
            'not_found'          => __( 'No items found.',PLUGIN_DOMAIN ),
            'not_found_in_trash' => __( 'No items found in Trash.',PLUGIN_DOMAIN )
        );

        $args = array(
            'label'              => $singular_name,
            'description'        => __( 'Description',PLUGIN_DOMAIN ),
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_admin_bar'  => false,
            'show_in_nav_menus'  => false,
            'menu_icon'          => 'dashicons-format-gallery',
            'query_var'          => true,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'can_export'         => true,
            'menu_position'      => 112,
            'taxonomies'         => array('category','post_tag'), //default wp taxonomies
            'exclude_from_search' => false,
            'supports'           => array( 'title','thumbnail' ) //editor, author

        );


        register_post_type($custom_post_type , $args );

        add_filter('manage_'.$custom_post_type.'_posts_columns',array($this,'set_custom_columns'));

        add_action('add_meta_boxes',array($this,'slider_meta_box'));

        add_action('save_post',array($this,'save_slider_post_meta_data'));

        add_action('after_switch_theme', array($this, 'rewrite_flush'));


    }


    public function set_custom_columns($columns){  //enable or disable columns. add new custom columns
        //return $columns;
        $column = array();
        $column['cb']='<input type="checkbox" />';
        $column['title'] = __('Tilte',PLUGIN_DOMAIN);
        $column['date'] = __('Date',PLUGIN_DOMAIN);

        return $column;

    }


    public function slider_meta_box($post){

        add_meta_box($post,'Slide settings:',array($this,'slider_meta_box_callback'),$post);

    }


    public function slider_meta_box_callback($post){//user email meta box callback

        $custom_post_type = $post->post_type;

        wp_nonce_field($custom_post_type.'_save_action',$custom_post_type.'_save_nonce');

        $post_meta = get_post_meta($post->ID);

        $slide_title = (isset($post_meta['slide_title']) )? esc_attr($post_meta['slide_title'][0]):'';
        $slide_text = (isset($post_meta['slide_text']) )? esc_attr($post_meta['slide_text'][0]):'';
        $slide_link_text = (isset($post_meta['slide_link_text']) )? esc_attr($post_meta['slide_link_text'][0]):'';

        echo '<input type="hidden" name="custom_post_type" value="'.$custom_post_type.'" />'; // hidden field
        ?>

        <table class="form-table">

            <tbody>

            <tr>
                <th scope="row"><?php _e('Slide title',PLUGIN_DOMAIN);?></th>
                <td>
                    <?php echo '<input type="text" name="'.Settings::$plugin.'['.$custom_post_type.'][slide_title]" value="'.$slide_title.'" placeholder="'.__('slide title',PLUGIN_DOMAIN).'" />';?>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Slide text',PLUGIN_DOMAIN);?></th>
                <td>
                    <?php echo '<textarea name="'.Settings::$plugin.'['.$custom_post_type.'][slide_text]" rows="8" placeholder="slide text">'.$slide_text.'</textarea>';?>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php _e('Slide link text',PLUGIN_DOMAIN);?></th>
                <td>
                    <?php echo '<input type="text" name="'.Settings::$plugin.'['.$custom_post_type.'][slide_link_text]" value="'.$slide_link_text.'" placeholder="'.__('slide link text',PLUGIN_DOMAIN).'" />';?>
                </td>
            </tr>

            </tbody>

        </table>

        <?php


    }


    public function save_slider_post_meta_data($post_id){


        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);

        if($is_autosave || $is_revision)
            return;

        if(!current_user_can('edit_post', $post_id))
            return;

        if(!isset($_POST['custom_post_type'])) //custom post type name
            return;

        $custom_post_type = sanitize_text_field( $_POST['custom_post_type'] );

        $nonce = ( isset($_POST[ $custom_post_type.'_save_nonce']) )? $_POST[ $custom_post_type.'_save_nonce']:'';
        $nonce_action = $custom_post_type.'_save_action';

        if(!wp_verify_nonce($nonce, $nonce_action ))
            return;


        if(!isset($_POST[Settings::$plugin][$custom_post_type]))
            return;


        if(isset($_POST[Settings::$plugin][$custom_post_type]['slide_title'])){

            $slide_title = sanitize_text_field( $_POST[Settings::$plugin][$custom_post_type]['slide_title'] );

            update_post_meta($post_id,'slide_title',$slide_title);
        }

        if(isset($_POST[Settings::$plugin][$custom_post_type]['slide_text'])){

            $slide_text = sanitize_text_field( $_POST[Settings::$plugin][$custom_post_type]['slide_text'] );

            update_post_meta($post_id,'slide_text',$slide_text);
        }

        if(isset($_POST[Settings::$plugin][$custom_post_type]['slide_link_text'])){

            $slide_link_text = sanitize_text_field( $_POST[Settings::$plugin][$custom_post_type]['slide_link_text'] );

            update_post_meta($post_id,'slide_link_text',$slide_link_text);
        }


    }


    public function rewrite_flush()
    {
        // call the CPT init function
        $this->init_custom_post_type();

        // Flush the rewrite rules only on theme activation
        flush_rewrite_rules();
    }



} 