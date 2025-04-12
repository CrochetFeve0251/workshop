<?php

namespace Workshop\Tests\Integration\inc;

use Workshop\Kernel\EventManager\EventManager;
use Workshop\Tests\Integration\TestCase;
use WPMedia\PHPUnit\Integration\AdminTestCase;

class FetchSitemapTest extends AdminTestCase
{
    protected $response;

    public function set_up()
    {
        parent::set_up();
        delete_option('sitemap_sitemap_exists');
        add_filter('pre_http_request', [ $this, 'mock_http_request' ], 10, 3);
    }

    public function tear_down()
    {
        remove_filter('pre_http_request', [ $this, 'mock_http_request' ], 10);
        delete_option('sitemap_sitemap_exists');
        parent::tear_down();
    }

    public function testNoSitemapShouldNotSet() {

        $this->response = new \WP_Error('not_found', 'message');

        do_action( 'admin_init' );

        $this->assertFalse(get_option('sitemap_sitemap_exists', false));
    }

    public function testSitemapNotXmlShouldNotSet() {

        $this->response = [
            'response' => [
                'code' => 200,
                'headers' => [],
                'response' => [],
                'cookies' => [],
            ],
            'body' => json_encode( (object) [
                'success' => false,
                'errors' => [
                    (object) [
                        'code' => 6003,
                    ],
                ],
            ] ),
        ];

        do_action( 'admin_init' );

        $this->assertFalse(get_option('sitemap_sitemap_exists', false));
    }

    public function testSitemapXmlShouldSet() {

        $this->response = [
            'response' => [
                'code' => 200,
                'headers' => [],
                'response' => [],
                'cookies' => [],
            ],
            'body' => "<?xml version='1.0' encoding='UTF-8'?><url>url</url>",
        ];

        do_action( 'admin_init' );

        $this->assertTrue(get_option('sitemap_sitemap_exists', true));
    }

    public function mock_http_request($resp, $args, $url) {
        if('http://localhost:8888/?sitemap=index' !== $url) {
            return $resp;
        }

        return $this->response;
    }

}