<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\setup\Settings;

class ContactformCallback {

    public static function contactform(){

        require_once(Settings::$plugin_path . '/inc/modules/' . ContactformSetup::$module . '/template/' . ContactformSetup::$module .'.php');

    }


    public static function field_contact_form_activate_deactivate(){

        $params = array(
            'id'=>'contact_activate_deactivate',
            'class'=>'',
        );

        $checked = ( isset(Settings::$plugin_db['modules'][ ContactformSetup::$module ]['contact_activate_deactivate']) && Settings::$plugin_db['modules'][ ContactformSetup::$module ]['contact_activate_deactivate'] == 1 )? 'checked':'';

        $output='<div class="form-check">';
        $output.='<label class="form-check-label" for="'.esc_attr($params['id']).'">';
        $output.='<input type="checkbox" id="'.esc_attr($params['id']).'" name="'. Settings::$plugin_option.'[modules]['.ContactformSetup::$module.'][contact_activate_deactivate]" class="form-check-input '.esc_attr($params['class']).'" value="1" '.esc_attr($checked).' >';
        $output.= '</label>';
        $output.='</div>';

        echo $output;

    }


    public static function field_contact_form_send_email(){

        $params = array(
            'id'=>'contact_send_email',
            'class'=>'',
        );

        $checked = ( isset(Settings::$plugin_db['modules'][ ContactformSetup::$module ]['contact_send_email']) && Settings::$plugin_db['modules'][ ContactformSetup::$module ]['contact_send_email'] == 1 )? 'checked':'';

        $output='<div class="form-check">';
        $output.='<label class="form-check-label" for="'.esc_attr($params['id']).'">';
        $output.='<input type="checkbox" id="'.esc_attr($params['id']).'" name="'. Settings::$plugin_option.'[modules]['.ContactformSetup::$module.'][contact_send_email]" class="form-check-input '.esc_attr($params['class']).'" value="1" '.esc_attr($checked).' >';
        $output.= '</label>';
        $output.='</div>';

        echo $output;

    }

}