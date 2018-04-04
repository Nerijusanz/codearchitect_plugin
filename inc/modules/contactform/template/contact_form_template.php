<?php
/**
 * @package codearchitect
 */
?>

<div class="awps-contact-form-wrap">


    <div class="awps-contact-form-response-message js-awps-contact-form-response-message"></div>

    <form action="#" method="post" id="awps-contact-form" class="awps-contact-form"
          data-url="<?php echo admin_url('admin-ajax.php'); ?>">

        <div class="form-group">
            <label for="name"><?php _e('vardas',PLUGIN_DOMAIN);?></label>
            <input type="text" id="name" class="form-control js-awps-contact-name" placeholder="vardas"
                   name="name" maxlength="50">

        </div>

        <div class="form-group">
            <label for="email"><?php _e('El. paštas',PLUGIN_DOMAIN);?></label>
            <input id="email" type="text" class="form-control js-awps-contact-email" placeholder="el.paštas"
                   name="email" maxlength="50">
        </div>

        <div class="form-group">
            <label for="message"><?php _e('žinutė',PLUGIN_DOMAIN);?></label>
            <textarea id="message" name="message" class="form-control js-awps-contact-message"
                      placeholder="žinutė"></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-sm form-btn"><?php _e('Siųsti',PLUGIN_DOMAIN);?></button>

    </form>
            <!--#awps-contact-form-->

</div><!--awps-contact-form-wrap-->