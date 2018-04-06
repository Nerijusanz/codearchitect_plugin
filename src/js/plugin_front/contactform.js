class Contactform{
    //file: header.php

    constructor(){

        this.init();

    }

    init(){

        //STATIC VARIABLES
        var ajaxurl = ca_localize.ajaxurl;  //plugin localize settings

        var form =  $('#ca-contact-form'); //take form object: ./views/contact-form.php
        var form_message_block = $('.js-ca-contact-form-response-message'); //message block before form, show response messages
        var el_name = '.js-ca-contact-name';
        var el_email = '.js-ca-contact-email';
        var el_message = '.js-ca-contact-message';

        //DYNAMIC VARIABLES
         var fld_name = form.find( el_name );  //form input field 'name'
         var fld_email = form.find( el_email );    //form input field 'email'
         var fld_message = form.find( el_message );    //form input textarea 'message'



        form.on('submit',function(e){
            e.preventDefault();

            form_refresh_data();//IMPORTANT!!! every time on clicked form call to refresh form data again; removes errors;

            //get wp ajax url, defined at html form data-ajaxurl;
            if(typeof ajaxurl ==='undefined' || ajaxurl=='') return;   //make validation: if ajax url exists, if not STOP code; form can`t do ajax call;

            make_response_message('process');  //show message do 'process' in response message block while ajax get server-side response;
            make_input_disable(true);//deactivate all input and submit button; true - add disabled "on" while processing ajax data; check function below;

            //do form data validation.
            //note: validation is static function, if need to add new input field, also need to do create new validation for that field: look function, how validation is going.
            if( make_input_validation() == false ) { //if validation return false, that`s mean occurs error on validation process;

                //grecaptcha.reset(); //IMPORTANT!!! add google recaptcha at start position "not clicked";
                make_response_message('validation');    //add validation message into HTML DOM: "form_message_block"->.js-ca-contact-form-response-message
                make_input_disable(false); //make active all inputs and submit button.
                return;//STOP CODE !!! VALIDATION ERROR!!!

            }

            make_ajax_contact_form(); //make CONTACT FORM ajax call to server: .config/custom/contactForm.php



        });//form.submit



        function form_refresh_data(){
            //note: catch dynamic form data;
            form.find('.form-control').removeClass('js-field-error'); //remove from input field error classes: "border red";
            form.find('.js-form-control-msg').remove();// remove before input field added validation messages from HTML DOM

            fld_name = form.find( el_name );  //form input field 'name'
            fld_email = form.find( el_email );    //form input field 'email'
            fld_message = form.find( el_message );    //form input textarea 'message'

        }


        function make_ajax_contact_form(){


            $.ajax({    //server-side: .config/custom/contactForm.php
                url:ajaxurl,
                type:'post',
                data:{
                    action:'contactform_ajax', //make to know wordpress ajax, which function should do ajax php code on server-side
                    name:fld_name.val(),
                    email:fld_email.val(),
                    message:fld_message.val()

                },
                error:function(response){

                    make_response_message('error');  //show response error; error type: response;

                    make_input_disable(false);//make all inputs active again. "turn off" disabled parameter

                },
                success:function(response){

                    var data  = JSON.parse(response);   //response json encoded json format. make decode;

                    var status = data.contact_status;	//1 or 0;
                    var message = data.contact_message; //get server-side messages list;
                    var fields = data.contact_field;    //get input fields list, which input got validation error on server-side;

                    generate_response_message_list(message,status);    //look function below; send 2 params: message list, and response status;

                    if(status == 0) {//response: validation got error server-side

                        make_input_disable(false); //make all inputs active. "turn off" disabled parameter
                        make_field_border_red(fields); //look function below;add border red on fields which got error on server-side
                    }

                    if(status == 1){form.fadeToggle(320);}  //if status 1, that`s mean everything is ok; close the form;


                }//success block
            });//.end ajax


        }


        function make_input_validation(){ //form input fields which need to validate

            var name_val = fld_name.val();
            var email_val = fld_email.val();
            var message_val = fld_message.val();

            var validation_error = false;   //make start needle;


            if(name_val == '' || name_val.length < 2 ){ //two or more characters
                validation_error = true;    //trigger validation error
                make_validation_message(fld_name,'name');  // 1 param: input field, 2 param: message name

            }

            if(name_val.length>255){    //max characters 255
                validation_error=true;  //trigger error
                make_validation_message(fld_name,'name_long_input');  //1param:
            }


            if( validateEmail(email_val) === false ){   //function validateEmail() function look below
                validation_error = true;
                make_validation_message(fld_email,'email');
            }


            if(email_val.length>255){
                validation_error=true;
                make_validation_message(fld_email,'email_long_input');
            }


            if(message_val =='' || message_val.length < 2){
                validation_error = true;//trigger error
                make_validation_message(fld_message,'message');
            }

            //if occurs error on validation process
            if(validation_error == true ) return false;  //return false, which mean in validation process was trigger error


            return true;    //validation process ok;

        }


        function validateEmail(email)
        {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
            {
                return true;//email tested ok;
            }

            return false;
        }


        function make_input_disable(status){    //status:true or false; - all inputs fields disabled "turn on" or "turn off", false-remove disabled property
            form.find(':input').prop('disabled',status);//take all input elements, not only tags, but all inputs: input,select,textarea,button,checkbox,radio...
        }


        function make_field_border_red(fields){//fields list coming from server-side ajax call, fields name indicate which fields got error on server-side validation, and need to add border red

            if(fields.length > 0) {   //field list is not empty;

                $.each(fields, function (index, field) {
                    //for example: from server-side get input fields list which had error: name,email,message;
                    form.find('.js-ca-contact-' + field).addClass('js-field-error'); // generate: .js-ca-contact-name,.js-ca-contact-email,.js-contact-message;

                });

            }

        }


        function generate_response_message_list(messages,status){

            var msg_class_status = (status == 0)?'error':'success'; // class depend on server-side response_status: 0 or 1; different css styles; look at: .scss/custom/contact_form.scss

            var output='<ul class="'+msg_class_status+'">';

            if(messages.length > 0) {  //message list is not empty;

                $.each(messages, function (index, msg) {

                    output += '<li>' + msg + '</li>';
                });

            }

            output+='</ul>';

            form_message_block.html(output).fadeOut(4000);   //response message block are defined at html DOM; look; html form: ./views/contact-form.php

        }


        function make_validation_message(field,name){   //input field error message;

            var type = 'validation';

            var msg_string = '<small class="text-danger js-form-control-msg">'+message(type,name)+'</small>';   //message string after input field
            //add message before input field;//add has error class
            field.before(msg_string).addClass('js-field-error');

        }


        function make_response_message(name){

            var class_name='';

            switch(name){
                case 'process':class_name='process';break;
                case 'success':class_name='success';break;
                case 'error':class_name='error';break;
                case 'validation':class_name='error';break;
            }


            var type = 'response';

            var msg_string = '<ul class="'+class_name+'"><li>'+message(type,name)+'</li></ul>';

            form_message_block.html(msg_string);   //response message block are defined at contact_form; look at html form: ./views/contact-form.php


        }




        function message(type,name){

            //for example to call function: message('validation','name'); message('response','process');

            var msgObj ={
                'contact_form': {

                    validation:{
                        'name': 'Neįvestas vardas. Vardą turi sudaryti mažiausiai 2 simboliai',
                        'name_long_input':'Klaida! raidžių skaičius laukelyje "vardas:" negali viršyti 255',
                        'email': 'Neįvestas elektroninis paštas arba neteisingai įvedėte elektroninį paštą',
                        'email_long_input':'Klaida! raidžių skaičius laukelyje "elektroninis paštas:" negali viršyti 255',
                        'message': 'Neįvesta žinutė. Mažiausias žinutės simbolių skaičius turi būti 2'
                    },

                    response:{
                        'process':'prašome palaukti...',
                        'success':'jūsų žinutė sėkmingai buvo iššsiųsta.',
                        'error': 'įvyko klaida. Bandykite dar kartą, arba vėliau.',
                        'validation':'Užpildykite visus esančius laukelius.'
                    }

                }

            }

            return msgObj['contact_form'][type][name];

        }


    }//init


}

export default Contactform;