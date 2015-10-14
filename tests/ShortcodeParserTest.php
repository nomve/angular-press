<?php


namespace AngularPress\Tests;


class ShortcodeParserTest extends \WP_Mock\Tools\TestCase {

    private $shortcodeParser;

    public function setUp() {
        parent::setUp();
        $this->shortcodeParser = new \AngularPress\ShortcodeParser();
    }

    public function tearDown() {
        parent::tearDown();
        unset($this->shortcodeParser);
    }
    /**
     * 
     */
    public function testAddedGalleryShortcodeParsing() {

        \WP_Mock::expectFilterAdded(
            'post_gallery',
            array(
                $this->shortcodeParser,
                'parseGallery'
            ),
            0,
            2
        );

        $this->shortcodeParser->addFilters();
    }
    /**
     *
     */
//    public function testAngularGalleryShortcodeParsing() {
//
//        $galleryShortcode = '[gallery id="4"]';
//    }
}
