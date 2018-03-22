<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\cpt\template;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\modules\cpt\CptSetup;

?>

<div class="page">

    <?php echo ModulesSetup::generate_modules_top_navigation();?>


    <div class="wrap">
        <?php
        $title_txt = sprintf('%s %s',
                        CptSetup::$module_title,
                        __('module',PLUGIN_DOMAIN)  //localization
                    );
        ?>

        <h2><?php esc_html_e($title_txt);?></h2>

        <?php CptSetup::render_template();?>

    </div><!--wrap-->

</div><!--page-->
