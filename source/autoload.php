<?php
spl_autoload_register( function ($className) {
    
    if ( false === strpos($className, 'AngularPress') )
        return;

    $className = str_replace('AngularPress\\', __DIR__ . '/classes/', $className) . '.php';
    
    if ( is_readable($className) ) {
        include $className;
    }
        
});