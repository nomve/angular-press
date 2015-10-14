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
    public function testAngularGalleryShortcodeParsing() {

        $imageId = 4;

        $attributes = array(
            'ids' => $imageId
        );
        $galleryShortcode = sprintf( '[gallery id="%s"]', $imageId );

        \WP_Mock::wpFunction(
            'wp_get_attachment_image_src',
            array(
                'times' => 1,
                'args' => array(
                    $imageId,
                    'full'
                ),
                'return' => array(
                    'path', 300, 200
                )
            )
        );

        $result = $this->shortcodeParser->parseGallery(null, $attributes);

        $this->assertTrue( $result === '<gallery images="[{"src":"path","width":300,"height":200}]"></gallery>' );
    }
}
