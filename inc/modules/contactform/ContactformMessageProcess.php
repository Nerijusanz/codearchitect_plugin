<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\modules\contact;

class ContactformMessageProcess {

    public $msg_list = array();
    public $field_list = array();
    public $validation_error;

    public static $custom_post_type;
    public static $company_email;
    public static $send_email_status;

    public function __construct(){

        $this->validation_error=false;  //make start validation status needle;
        self::$custom_post_type = ContactformMessageCpt::$custom_post_type;
        self::$send_email_status = Setup::check_send_email_status(); //return true or false;

        self::$company_email = contact\Setup::get_company_email();  //note: contact/Setup;

        //wordpress ajax making structure
        $awps_ajax_action_name = 'contactform_ajax';   //contact.js ajax send data parameter: action:'awps_contact_form';
        add_action('wp_ajax_nopriv_'.$awps_ajax_action_name,array($this,'ajax_data_process'));
        add_action('wp_ajax_'.$awps_ajax_action_name,array($this,'ajax_data_process'));

    }


    public function ajax_data_process(){

        $name = (isset($_POST['name']))?sanitize_text_field($_POST['name']):'';
        $email = (isset($_POST['email']))?sanitize_text_field($_POST['email']):'';
        $message = (isset($_POST['message']))?sanitize_text_field($_POST['message']):'';


        //add form input fields into input validation.
        // !IMPORTANT: this is static function! if need to add new input field, also need to do create new validation for that field: look function below, how validation is going.
        //if validation return false, that`s mean occurs error on validation process;
        if($this->make_input_validation($name,$email,$message) == false){  //if in validation process was trigger error

            $response_status=0;// make response_status 0, which indicate ajax, was error in server-side;

        }else{// validation ok;

            $postID = self::save_message($name,$email,$message);   //function insert post and return current post id or occurs error and return 0;

            if($postID !== 0) {  //make check if post are successfully inserted;

                /*//!!!IMPORTANT!!!! ACTIVATE EMAIL ON REAL SERVER, EMAIL NOT WORKING ON LOCAL SERVER;*/
                if(self::$send_email_status == true)
                    self::send_email($name,$email,$message);

                $response_status=1; //make response status 1, everything goes ok;
                $this->msg_list[] = self::message('success'); //make message success
            }else{
                $response_status=0; //make response status 0; error: post are not inserted;
                $this->msg_list[] = self::message('error'); //make message error
            }

        }

        //format return data: use PHP object format structure;
        $msgObj = new \stdClass();
        $msgObj->contact_status = $response_status; //1 or 0;
        $msgObj->contact_message = $this->msg_list; //take all messages
        $msgObj->contact_field = $this->field_list; //take fields list: field indicate: which input field got error on validation process server-side

        $output=json_encode( $msgObj, JSON_UNESCAPED_UNICODE ); //JSON_UNESCAPED_UNICODE - do not remove charset=utf-8


        echo $output;   //return to ajax
        die();

    }


    public function make_input_validation($name,$email,$message){   //make inputs  validation;

        if($name =='' || strlen($name)< 2 ) //not empty or less than 2 characters
            $this->make_validation_error('name','name'); //param1: set field name; param2: set message type;


        if(strlen($name)>255)  //max 255
            $this->make_validation_error('name','name_long_input'); //field:name; message:name_long_input;


        if(filter_var($email,FILTER_VALIDATE_EMAIL) === false)//PHP native function filter_var(); look php documentation;
            $this->make_validation_error('email','email'); //field:email; message:email


        if(strlen($email)>255)
            $this->make_validation_error('email','email_long_input');//field:email; message:email_long_input


        if($message =='' || strlen($message)< 2)
            $this->make_validation_error('message','message');//field:message; message:message


        //if occurs error on validation process;
        if($this->validation_error == true) return false;   //return false, which mean in validation process was trigger error;


        return true;    //validation process ok;

    }


    public function make_validation_error($field,$message){

        $this->validation_error=true;   //trigger error on validation process;
        $this->msg_list[]=self::message($message); //add validation message into message list;
        $this->field_list[]=$field;   //add input field name into list; fields name indicate which current field got error on server-side validation;
    }


    public static function save_message($name,$email,$message){

        $args=array(
            'post_title'=>$name,    //name data is storing into title field
            'post_content'=>$message,
            'post_author'=>1,   //wp user id , in wp users table
            'post_type'=>self::$custom_post_type, //custom post type: contact_message     wp->panel->Contact Message;
            'post_status'=>'publish',
            'meta_input'=>array(
                'user_email'=> $email    //post meta field: user_email;
            )
        );

        $postID = wp_insert_post($args);    //create post and return current post id or occurs error and return 0;

        return $postID; //return current post id

    }


    public static function send_email($name,$email,$message){

        if(empty(self::$company_email))
            return;

        $to = self::$company_email;
        $subject = 'Contact Form - message from: ' . $name;

        $headers = array();
        $headers[] = 'From: ' . get_bloginfo('name') . '<' . $to . '>';  //standard format that`s email recognize; get the site name: wp->panel->general->Site_Title;
        $headers[] = 'Reply-To: ' . $name . '<' . $email . '>'; //user email coming from front-end contact from;
        $headers[] = 'Content-Type:text/html; charset=UTF-8';

        wp_mail($to,$subject,$message,$headers);

    }


    public static function message($type){
        //for example usage: self::message('name');
        $msg=array();

        $msg['contact_form']['name'] = __('No name entered. The name must be at least 2 characters long',PLUGIN_DOMAIN);
        $msg['contact_form']['name_long_input'] = __('Error! The number of letters in the "name:" field can not exceed 255',PLUGIN_DOMAIN);

        $msg['contact_form']['email'] = __('You have not entered an email or incorrectly entered your email',PLUGIN_DOMAIN);
        $msg['contact_form']['email_long_input'] = __('Error! The number of letters in the field "e-mail:" can not exceed 255',PLUGIN_DOMAIN);

        $msg['contact_form']['message'] = __('Message not entered. The minimum number of characters in the message must be 2',PLUGIN_DOMAIN);


        $msg['contact_form']['success'] = __('Your message has been successfully sent.',PLUGIN_DOMAIN);
        $msg['contact_form']['error'] = __('error occurred. Try again, or later',PLUGIN_DOMAIN);

        /*
        $msg['contact_form']['name'] = __('Neįvestas vardas. Vardą turi sudaryti mažiausiai 2 simboliai',PLUGIN_DOMAIN);
        $msg['contact_form']['name_long_input'] = __('Klaida! raidžių skaičius laukelyje "vardas:" negali viršyti 255',PLUGIN_DOMAIN);

        $msg['contact_form']['email'] = __('Neįvestas elektroninis paštas arba neteisingai įvedėte elektroninį paštą',PLUGIN_DOMAIN);
        $msg['contact_form']['email_long_input'] = __('Klaida! raidžių skaičius laukelyje "elektroninis paštas:" negali viršyti 255',PLUGIN_DOMAIN);

        $msg['contact_form']['message'] = __('Neįvesta žinutė. Mažiausias žinutės simbolių skaičius turi būti 2',PLUGIN_DOMAIN);


        $msg['contact_form']['success'] = __('jūsų žinutė sėkmingai buvo iššsiųsta.',PLUGIN_DOMAIN);
        $msg['contact_form']['error'] = __('įvyko klaida. Bandykite dar karta, arba vėliau',PLUGIN_DOMAIN);
        */

        return $msg['contact_form'][$type];

    }

} 