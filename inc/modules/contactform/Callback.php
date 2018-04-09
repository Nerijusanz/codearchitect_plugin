<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class Callback {

    public static function template(){

        ModulesSetup::get_modules_page_template(Setup::$module);

    }


    public static function field_contact_form_activate_deactivate(){

        $params = array(
            'id'=>'contact_activate_deactivate',
            'class'=>'',
        );

        $checked = ( isset(Settings::$plugin_db['modules'][ Setup::$module ]['contact_activate_deactivate']) && Settings::$plugin_db['modules'][ Setup::$module ]['contact_activate_deactivate'] == 1 )? 'checked':'';

        $output='<div class="form-check">';
        $output.='<label class="form-check-label" for="'.esc_attr($params['id']).'">';
        $output.='<input type="checkbox" id="'.esc_attr($params['id']).'" name="'. Settings::$plugin_option.'[modules]['.Setup::$module.'][contact_activate_deactivate]" class="form-check-input '.esc_attr($params['class']).'" value="1" '.esc_attr($checked).' >';
        $output.= '</label>';
        $output.='</div>';

        echo $output;

    }


    public static function field_contact_form_send_email(){

        $params = array(
            'id'=>'contact_send_email',
            'class'=>'',
        );

        $checked = ( isset(Settings::$plugin_db['modules'][ Setup::$module ]['contact_send_email']) && Settings::$plugin_db['modules'][ Setup::$module ]['contact_send_email'] == 1 )? 'checked':'';

        $output='<div class="form-check">';
        $output.='<label class="form-check-label" for="'.esc_attr($params['id']).'">';
        $output.='<input type="checkbox" id="'.esc_attr($params['id']).'" name="'. Settings::$plugin_option.'[modules]['.Setup::$module.'][contact_send_email]" class="form-check-input '.esc_attr($params['class']).'" value="1" '.esc_attr($checked).' >';
        $output.= '</label>';
        $output.='</div>';

        echo $output;

    }

}