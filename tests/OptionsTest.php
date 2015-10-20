<?php


namespace AngularPress\Tests;


class OptionsTest extends \WP_Mock\Tools\TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();
    }
    /**
     * 
     */
    public function testShowsCurrentlySavedOptions() {
        
        $options = new \AngularPress\Options();

        \WP_Mock::wpFunction(
            'get_option',
            array(
                'times' => 1,
                'args' => array(
                    $options->getOptionsField()
                ),
                'return' => 1
            )
        );
        
        $this->assertTrue( $options->getGalleryTemplate() === 1 );
    }
    
}
