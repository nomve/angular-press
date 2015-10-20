<?php
/*
 * Plugin Name: Angular-Press
 */

require_once( __DIR__ . '/vendor/autoload.php' );
require_once( 'defines.php' );

$plugin = new \AngularPress\Plugin();

register_activation_hook(
    ANGULAR_PRESS_PLUGIN_FILE,
    array(
        $plugin,
        'pluginActivation'
    )
);

register_deactivation_hook(
    ANGULAR_PRESS_PLUGIN_FILE,
    array(
        $plugin,
        'pluginDeactivation'
    )
);