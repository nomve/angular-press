<?php


namespace AngularPress;


class Options {
    
    const OPTIONS_FIELD = 'angular_press_options';

    private $shortcodes;

    public function __construct() {

        $this->shortcodes = array(
            'gallery'
        );
    }
    /*
     *
     */
    public function getShortcodes() {
        return $this->shortcodes;
    }
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
        return \get_option( self::OPTIONS_FIELD );
    }
}