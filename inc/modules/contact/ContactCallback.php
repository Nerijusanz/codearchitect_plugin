<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contact;

use CA_Inc\setup\Settings;


class ContactCallback {


    public static function template(){

        return require_once(Settings::$plugin_path . '/inc/modules/' . ContactSetup::$module . '/template/' . ContactSetup::$module .'.php');

    }


    public static function field_company_name(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company name',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_name']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_name']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_name]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_address(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company address',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_address']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_address']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_address]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_code(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company code',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_code']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_code']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_code]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_pvm_code(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company pvm code',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_pvm_code']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_pvm_code']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_pvm_code]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_phone_fax(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company phone/fax',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_phone_fax']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_phone_fax']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_phone_fax]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_mobile(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company mobile',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_mobile']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_mobile']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_mobile]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_email(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company email',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_email']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_email']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_email]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_working_hours(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company working hours',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_working_hours']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_working_hours']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_working_hours]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_bank_name(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('bank name',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_name']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_name']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][bank_name]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_bank_address(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('bank address',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_address']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_address']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][bank_address]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_bank_code(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('bank code',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_code']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_code']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][bank_code]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_bank_swift_bic_code(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('bank swift/bic',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_swift_bic_code']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_swift_bic_code']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][bank_swift_bic_code]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    public static function field_bank_account_number(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('bank account number',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_account_number']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['bank_account_number']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][bank_account_number]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

} 