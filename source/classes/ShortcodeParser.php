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
        $size = empty($attributes['size']) ? 'thumbnail' : $attributes['size'];
        $link = empty($attributes['link']) ? 'post' : $attributes['link'];

        if ( empty($ids) )
            return '';

        $imageObjects = array_map( function($id) use(&$size, &$link) {
            
            return new Data\Image($id, $size, $link);
        }, $ids);

        return '<gallery images="' . json_encode($imageObjects) . '"></gallery>';
    }
}