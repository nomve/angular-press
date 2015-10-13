<?php


namespace AngularPress\Tests;


class ShortcodeParserTest extends \WP_Mock\Tools\TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();
    }
    /**
     * 
     */
    public function testAddedGalleryShortcodeParsing() {
        
        \WP_Mock::expectFilterAdded(
            'post_gallery',
            array(
                new \AngularPress\ShortcodeParser,
                'parseGallery'
            ),
            0,
            2
        );
        
        new \AngularPress\ShortcodeParser;
    }
}
