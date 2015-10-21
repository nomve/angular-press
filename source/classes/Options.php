<?php


namespace AngularPress;


class Options {
    
    const OPTIONS_FIELD = 'angular_press_options';
    
    /**
     * 
     */
    public function getOptionsField() {
        return self::OPTIONS_FIELD;
    }
    /**
     * 
     */
    public function getAll() {
        return get_option( self::OPTIONS_FIELD );
    }
}