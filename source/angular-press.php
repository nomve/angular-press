<?php
/*
 * Plugin Name: Angular-Press
 */

require_once( 'autoload.php' );

register_activation_hook(
    ANGULAR_PRESS_PLUGIN_FILE,
    array(
        new \AngularPress\Plugin,
        'pluginActivation'
    )
);