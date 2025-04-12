<?php

namespace Workshop\ChangeSitemap;

use Workshop\Kernel\EventManager\SubscriberInterface;

class Subscriber implements SubscriberInterface
{

    public static function get_subscribed_events()
    {
       return [
           'init' => 'add_redirect_rule',
           'home_url' => [
               'change_url_sitemap',
               10,
               2
           ]
       ];
    }

    public function add_redirect_rule() {
        $sitemap = get_option('sitemap_sitemap_url', '');

        if( ! $sitemap ) {
            return;
        }

        add_rewrite_rule('^' . preg_quote($sitemap) . '$', 'index.php?sitemap=index', 'top');
    }

    public function change_url_sitemap($url, $path) {
        $sitemap = get_option('sitemap_sitemap_url', '');

        if('/wp-sitemap.xml' !== $path || ! $sitemap ) {
            return $url;
        }

        return str_replace('/wp-sitemap.xml', '/' . $sitemap, $url);
    }
}