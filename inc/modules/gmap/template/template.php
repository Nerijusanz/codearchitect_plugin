<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap\template;

use CA_Inc\modules\gmap\Setup;
use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\modules\gmap\table\Table;


?>

<div class="page">
    <?php

    echo ModulesSetup::generate_modules_top_navigation();

    ?>

    <div class="wrap">
        <?php
        $title_txt = sprintf('%s %s',
            Setup::$module_title,
            __('module',PLUGIN_DOMAIN)  //localization
        );
        ?>

        <h2><?php esc_html_e($title_txt);?></h2>

        <div class="list-table">
            <?php Table::render_table_template(); ?>
        </div>


    </div><!--wrap-->

</div>

