<?php

register_deactivation_hook(
    ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE,
    array(
        new \AngularPress\Plugin,
        'pluginDeactivation'
    )
);