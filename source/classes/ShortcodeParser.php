<?php

namespace AngularPress;

class ShortcodeParser {

    private $options;

    public function __construct($options = '') {

        if ( empty($options) )
            $options = new Options();

        $this->options = $options;
    }
    /**
     *
     */
    public function addFilters() {

        add_filter( 'post_gallery', array($this, 'galleryCallback'), 0, 2 );
    }
    /**
     *
     */
    public function galleryCallback($currentValue, $attributes) {

        $ids = explode( ',', $attributes['ids'] );
        $size = empty($attributes['size']) ? 'thumbnail' : $attributes['size'];
        $link = empty($attributes['link']) ? 'post' : $attributes['link'];

        if ( empty($ids) )
            return '';

        $imageObjects = array_map( function($id) use($size, $link) {
            
            return new Data\Image($id, $size, $link);
        }, $ids);

        $templates = $this->options->getAll();
        if ( empty($templates['gallery']) )
            $templates['gallery'] = "<gallery images='%s'></gallery>";

        $galleryTemplate = $templates['gallery'];

        return sprintf( $galleryTemplate, json_encode($imageObjects) );
    }
}