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
        $size = ( empty($attributes['size']) ) ? 'thumbnail' : $attributes['size'];

        if ( empty($ids) )
            return '';

        $imageObjects = array_map( function($id) use(&$size) {
            $obj = new \stdClass;
            $image = wp_get_attachment_image_src( $id, $size );
            $obj->src = $image[0];
            $obj->width = $image[1];
            $obj->height = $image[2];
            return $obj;
        }, $ids);

        return '<gallery images="' . json_encode($imageObjects) . '"></gallery>';
    }
}