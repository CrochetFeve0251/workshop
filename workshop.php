<?php
/**
 * Plugin Name: Workshop
 */

function sitemap_add_redirect_rule() {
    $sitemap = get_option('sitemap_sitemap_url', '');

    if( ! $sitemap ) {
        return;
    }

    add_rewrite_rule('^' . preg_quote($sitemap) . '$', 'index.php?sitemap=index', 'top');
}

add_action('init', 'sitemap_add_redirect_rule');

function sitemap_change_url_sitemap($url, $path) {
    $sitemap = get_option('sitemap_sitemap_url', '');

    if('/wp-sitemap.xml' !== $path || ! $sitemap ) {
        return $url;
    }

    return str_replace('/wp-sitemap.xml', '/' . $sitemap, $url);
}

add_filter('home_url', 'sitemap_change_url_sitemap', 10, 2);