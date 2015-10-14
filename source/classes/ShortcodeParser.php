<?php

namespace AngularPress;

class ShortcodeParser {

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
        // wordpress default size is 'thumbnail'
        $size = empty($attributes['size']) ? 'thumbnail' : $attributes['size'];

        if ( empty($ids) )
            return '';

        $imageObjects = array_map( function($id) use(&$size) {
            
            return new Data\Image($id, $size);
        }, $ids);

        return '<gallery images="' . json_encode($imageObjects) . '"></gallery>';
    }
}