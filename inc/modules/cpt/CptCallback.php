<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\cpt;

use CA_Inc\setup\Settings;


class CptCallback
{



    public static function template()
    {
        CptSetup::cpt_main_page();


    }

    //hidden field
    public static function field_cpt_module_id($value=''){

        echo '<input type="hidden" name="'.Settings::$plugin_option.'['.CptSetup::$module.'][module][module_id]" value="'.esc_html($value).'" />';

    }



    public static function field_cpt_module_name($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('module name',PLUGIN_DOMAIN),
            'required'=>'required'
        );

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'['.CptSetup::$module.'][module][module_name]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" '.esc_attr($params['required']).' />';

    }


    public static function field_singular_name($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('singular name',PLUGIN_DOMAIN),
            'required'=>'required'
        );


        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'['.CptSetup::$module.'][module][singular_name]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" '.esc_attr($params['required']).' />';

    }


    public static function field_plural_name($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('plural name',PLUGIN_DOMAIN),
            'required'=>'required'
        );

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'['.CptSetup::$module.'][module][plural_name]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" '.esc_attr($params['required']).' />';

    }

    public static function field_public_status($value=1){

        $params = array(
            'id'=>'public_status',
            'class'=>'',
        );

        $checked = ($value==1)?'checked':'';

        $output='<div class="form-check">';
        $output.='<label class="form-check-label" for="'.esc_attr($params['id']).'">';
        $output.='<input type="checkbox" id="'.esc_attr($params['id']).'" name="'. Settings::$plugin_option.'['.CptSetup::$module.'][module][public_status]" class="form-check-input '.esc_attr($params['class']).'" value="'.esc_html($value).'" '.esc_attr($checked).' >';
        $output.= '</label>';
        $output.='</div>';

        echo $output;

    }

    public static function field_archive_status($value=1){

        $params = array(
            'id'=>'archive_status',
            'class'=>''
        );

        $checked = ($value==1)?'checked':'';

        $output='<div class="form-check">';
        $output.='<label class="form-check-label" for="'.esc_attr($params['id']).'">';
        $output.='<input type="checkbox" id="'.esc_attr($params['id']).'" name="'. Settings::$plugin_option.'['.CptSetup::$module.'][module][archive_status]" class="form-check-input '.esc_attr($params['class']).'" value="'.esc_html($value).'" '.esc_attr($checked).' >';
        $output.= '</label>';
        $output.='</div>';

        echo $output;

    }


}