<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contact;

use CA_Inc\modules\api\ModulesApi;


class Module {


    public function __construct()
    {

        add_action('init',array($this,'init'));
    }


    public function init(){

        $this->admin_subpages();

        $this->sections();

        $this->fields();

    }


    public function admin_subpages()
    {

        $admin_subpages = array(
            array(
                'parent_slug' => Setup::$module_parent_slug,
                'page_title' => __(Setup::$module_title),
                'menu_title' => __(Setup::$module_title),
                'capability' => Setup::$module_capability,
                'menu_slug' => Setup::$module_slug,  //note: menu_slug on first admin subpage have to be same parent menu_slug;
                'callback' => function(){Callback::template();}
            )
        );

        ModulesApi::add_admin_subpages($admin_subpages);

    }


    public function sections()
    {

        $sections = array(
            array(
                'id' => Setup::$module_slug . '_index', //important: page.'_admin_index';
                'title' =>  '',
                //'callback'=>'',
                'page' => Setup::$module_slug
            )
        );

        ModulesApi::add_sections($sections);

    }


    public function fields()
    {

        $fields = array(

            array(
                'id' => Setup::$module.'_company_name',  //plugin_name+page+field_name;
                'title' => __('Company Name',PLUGIN_DOMAIN),    //localization
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_name();}

            ),
            array(
                'id' => Setup::$module.'_company_address',  //plugin_name+page+field_name;
                'title' => __('Company address',PLUGIN_DOMAIN), //localization
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_address();}
            ),
            array(
                'id' => Setup::$module.'_company_code',  //plugin_name+page+field_name;
                'title' => __('Company code',PLUGIN_DOMAIN), //localization
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_code();}
            ),
            array(
                'id' => Setup::$module.'_company_pvm_code',  //plugin_name+page+field_name;
                'title' => sprintf(__('%s tax code',PLUGIN_DOMAIN),'PVM'),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_pvm_code();}
            ),
            array(
                'id' => Setup::$module.'_company_phone_fax',  //plugin_name+page+field_name;
                'title' => __('Company phone/fax',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_phone_fax();}
            ),
            array(
                'id' => Setup::$module.'_company_mobile',  //plugin_name+page+field_name;
                'title' => __('Company mobile',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_mobile();}
            ),
            array(
                'id' => Setup::$module.'_company_email',  //plugin_name+page+field_name;
                'title' => __('Company email',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_email();}
            ),
            array(
                'id' => Setup::$module.'_company_working_hours',  //plugin_name+page+field_name;
                'title' => __('Company working hours',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_company_working_hours();}
            ),
            array(
                'id' => Setup::$module.'_bank_name',  //plugin_name+page+field_name;
                'title' => __('Bank name',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_bank_name();}
            ),
            array(
                'id' => Setup::$module.'_bank_address',  //plugin_name+page+field_name;
                'title' => __('Bank address',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_bank_address();}
            ),
            array(
                'id' => Setup::$module.'_bank_code',  //plugin_name+page+field_name;
                'title' => __('Bank address',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_bank_code();}
            ),
            array(
                'id' => Setup::$module.'_bank_swift_bic_code',  //plugin_name+page+field_name;
                'title' => __('Bank SWIFT/BIC',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_bank_swift_bic_code();}
            ),
            array(
                'id' => Setup::$module.'_bank_account_number',  //plugin_name+page+field_name;
                'title' => __('Bank account number',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){Callback::field_bank_account_number();}
            )

        );

        ModulesApi::add_fields($fields);

    }

} 