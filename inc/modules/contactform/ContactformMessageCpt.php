<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\setup\Settings;

class ContactformMessageCpt{

    public static $custom_post_type;
    public static $singular_name;
    public static $plural_name;

    public function __construct(){

        self::$custom_post_type = 'contactform_message';
        self::$singular_name = __('Contact Message',PLUGIN_DOMAIN);
        self::$plural_name = __('Contact Messages',PLUGIN_DOMAIN);

        add_action('init', array($this, 'register_custom_post_type'));

        add_filter('manage_'.self::$custom_post_type.'_posts_columns',array($this,'set_custom_columns'));
        add_action('manage_'.self::$custom_post_type.'_posts_custom_column',array($this,'columns_content_setup'),10,2); //custom columns content setup.
        add_action('add_meta_boxes',array($this,'meta_box'));

        add_action('save_post',array($this,'save_post_meta'));

        add_action('after_switch_theme', array($this, 'rewrite_flush'));

    }


    public function register_custom_post_type()
    {

        $labels = array(
            'name'               => self::$plural_name,   // _x( $plural_name, 'post type general name',PLUGIN_DOMAIN ),
            'singular_name'      => self::$singular_name, // _x( $singular_name, 'post type singular name',PLUGIN_DOMAIN ),
            'menu_name'          => self::$plural_name,   //_x( $plural_name, 'admin menu',PLUGIN_DOMAIN ),
            'name_admin_bar'     => self::$singular_name, //_x( $singular_name, 'add new on admin bar',PLUGIN_DOMAIN ),
            'add_new'            => _x( 'Add New', 'Post type',PLUGIN_DOMAIN ),
            'add_new_item'       => __( 'Add New',PLUGIN_DOMAIN ),
            'new_item'           => sprintf(__('New Item %s',PLUGIN_DOMAIN),self::$singular_name),// __( 'New item'.$singular_name,PLUGIN_DOMAIN ),
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
            'label'              => self::$singular_name,
            'description'        => __( 'Description',PLUGIN_DOMAIN ),
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,  //important
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_admin_bar'  => false,
            'show_in_nav_menus'  => false,
            'menu_icon'          => 'dashicons-email-alt',
            'query_var'          => true,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'can_export'         => true,
            'menu_position'      => 112,
            'taxonomies'         => array(), //array('category','post_tag'), //default wp taxonomies
            'exclude_from_search' => false,
            'supports'           => array( 'title','editor','author' ) //editor, author

        );


        register_post_type(self::$custom_post_type , $args );

    }


    public function set_custom_columns($columns){  //enable or disable columns. add new custom columns
        //return $columns;

        $column = array();
        $column['cb']='<input type="checkbox" />';
        $column['title'] = __('Name',PLUGIN_DOMAIN);  //replace field name 'title' into 'Name'
        $column['email'] = __('Email',PLUGIN_DOMAIN);
        $column['message'] = __('Message',PLUGIN_DOMAIN);
        $column['date'] = __('Date',PLUGIN_DOMAIN);

        return $column;

    }


    public function columns_content_setup($column,$post_id){    //note: this wp function is singular and do loop on every post and columns to add custom content

        $post_meta = get_post_meta($post_id);

        switch($column){

            case 'message':
                //echo get_the_content();   //show full message content in the message list
                echo get_the_excerpt();
                break;

            case 'email':
                $email = (isset($post_meta['user_email'][0]) )? esc_attr($post_meta['user_email'][0]):'';
                $email = (!empty($email))?'<a href="mailto:'.$email.'">'.$email.'</a>':'no email';
                echo $email;
                break;

        }

    }


    public function meta_box(){

        add_meta_box(self::$custom_post_type.'_contact_settings',__('Contact settings',PLUGIN_DOMAIN),array($this,'meta_box_callback'),self::$custom_post_type,'normal');

    }


    public function meta_box_callback($post){//user email meta box callback

        wp_nonce_field(self::$custom_post_type.'_save_action',self::$custom_post_type.'_save_nonce'); //$_POST['contact_message_user_email_meta_box_nonce_data']

        $post_meta = get_post_meta($post->ID);

        $user_email = (isset($post_meta['user_email']) )? $post_meta['user_email'][0]:'';

        ?>

        <input type="hidden" name="custom_post_type" value="<?php esc_html_e(self::$custom_post_type);?>" />

        <table class="form-table">

            <tbody>

                <tr>
                    <th scope="row"><?php _e('User email:',PLUGIN_DOMAIN);?></th>
                    <td>
                        <?php echo '<input type="text" name="'.Settings::$plugin.'[modules]['.Setup::$module.'][custom_post_type]['.self::$custom_post_type.'][user_email]" value="'.esc_attr($user_email).'" placeholder="'.__('user email',PLUGIN_DOMAIN).'" />';?>
                    </td>
                </tr>

            </tbody>

        </table>

        <?php

    }


    public function save_post_meta($post_id){


        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);

        if($is_autosave || $is_revision)
            return;

        if(!current_user_can('edit_post', $post_id))
            return;

        if(isset($_POST['custom_post_type']) && $_POST['custom_post_type'] != self::$custom_post_type ) //custom post type name
            return;

        $nonce = ( isset($_POST[ self::$custom_post_type.'_save_nonce']) )? $_POST[ self::$custom_post_type.'_save_nonce']:'';
        $nonce_action = self::$custom_post_type.'_save_action';

        if(!wp_verify_nonce($nonce, $nonce_action ))
            return;


        if(isset($_POST[Settings::$plugin][self::$custom_post_type]['user_email'])){

            $user_email = sanitize_text_field( $_POST[Settings::$plugin]['modules'][Setup::$module]['custom_post_type'][self::$custom_post_type]['user_email'] );

            update_post_meta($post_id,'user_email',$user_email);
        }


    }


    public function rewrite_flush()
    {
        // call the CPT init function
        $this->register_custom_post_type();

        // Flush the rewrite rules only on theme activation
        flush_rewrite_rules();
    }



} 