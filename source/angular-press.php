<?php
/*
 * Plugin Name: Angular-Press
 */

require_once( 'autoload.php' );
require_once( 'defines.php' );
require ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE;

register_activation_hook(
    ANGULAR_PRESS_PLUGIN_FILE,
    array(
        new \AngularPress\Plugin,
        'pluginActivation'
    )
);