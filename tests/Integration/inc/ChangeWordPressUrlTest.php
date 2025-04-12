<?php

namespace Workshop\Tests\Integration\inc;

use Workshop\Tests\Integration\TestCase;

class ChangeWordPressUrlTest extends TestCase
{
    protected $option_value;

    public function set_up()
    {
        parent::set_up();
        add_filter('pre_option_sitemap_sitemap_url', [$this, 'get_sitemap_option']);
    }

    public function tear_down()
    {
        remove_filter('pre_option_sitemap_sitemap_url', [$this, 'get_sitemap_option']);
        parent::tear_down();
    }

    public function testNotSitemapShouldReturnSame() {
       $this->option_value = 'sitemap.xml';
       $url = apply_filters('home_url', 'http://example.org/my-url', '/my-url');
        $this->assertSame('http://example.org/my-url', $url);
    }

    public function testSitemapShouldChange() {
        $this->option_value = 'sitemap.xml';
        $url = apply_filters('home_url', 'http://example.org/wp-sitemap.xml', '/wp-sitemap.xml');
        $this->assertSame('http://example.org/sitemap.xml', $url);
    }

    public function testSitemapAndEmptyOptionShouldReturnSame()
    {
        $this->option_value = '';
        $url = apply_filters('home_url', 'http://example.org/wp-sitemap.xml', '/my-url');
        $this->assertSame('http://example.org/wp-sitemap.xml', $url);
    }

    public function get_sitemap_option() {
        return $this->option_value;
    }
}