<?php

register_activation_hook(
    ANGULAR_PRESS_PLUGIN_FILE,
    array(
        'PluginInit',
        'pluginActivation'
    )
);