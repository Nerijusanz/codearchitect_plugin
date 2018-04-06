<?php
/**
 * @package codearchitect
 */
?>

<div class="ca-contact-form-wrap">


    <div class="ca-contact-form-response-message js-ca-contact-form-response-message"></div>

    <form action="#" method="post" id="ca-contact-form" class="ca-contact-form">

        <div class="form-group">
            <label for="name"><?php _e('vardas',PLUGIN_DOMAIN);?></label>
            <input type="text" id="name" class="form-control js-ca-contact-name" placeholder="<?php _e('vardas',PLUGIN_DOMAIN);?>" name="name" maxlength="50">
        </div>

        <div class="form-group">
            <label for="email"><?php _e('El. paštas',PLUGIN_DOMAIN);?></label>
            <input id="email" type="text" class="form-control js-ca-contact-email" placeholder="<?php _e('el.paštas',PLUGIN_DOMAIN);?>" name="email" maxlength="50">
        </div>

        <div class="form-group">
            <label for="message"><?php _e('žinutė',PLUGIN_DOMAIN);?></label>
            <textarea id="message" name="message" class="form-control js-ca-contact-message" placeholder="<?php _e('žinutė',PLUGIN_DOMAIN);?>"></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-sm form-btn"><?php _e('Siųsti',PLUGIN_DOMAIN);?></button>

    </form><!--#ca-contact-form-->

</div><!--ca-contact-form-wrap-->