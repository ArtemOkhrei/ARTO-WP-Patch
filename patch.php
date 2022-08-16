<?php

// Disable xmlrpc.php
add_filter( 'xmlrpc_enabled', '__return_false' );

// Setting CSV delimiter of file during products export (Woocommerce only)
add_filter('woocommerce_product_export_delimiter', function($delimiter) {
    return $delimiter = ';';
});

// Remove rss from head
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

// Remove wp-embed
add_action('wp_footer', function () {
    wp_dequeue_script('wp-embed');
});

// Remove wp generator tag
remove_action('wp_head', 'wp_generator');

// Remove shortlink tag and HTTP header
add_filter('after_setup_theme', function() {
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
    remove_action( 'template_redirect', 'wp_shortlink_header', 11);
});

// Disable emojis in WordPress
add_action('init', function() { 
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', function($plugins ) {
	  if ( is_array( $plugins ) ) {
        	return array_diff( $plugins, array( 'wpemoji' ) );
    	} else {
        	return array();
    	}
    });
});

// Remove /page/1/ from first page button
add_filter('paginate_links', function ($link) {

    if(strpos($link, '/page/1/') !== false) {

        $link = str_replace('/page/1/', '/', $link);

    }

    return $link;

});

// Remove word 'Billing' in errors of checkout page (Woocommerce only)
add_filter('woocommerce_add_error', function ($error) {
    if (strpos($error, 'Billing') !== false) {
        $error = str_replace('Billing', '', $error);
    }
    if (strpos($error, 'Оплата') !== false) {
        $error = str_replace('Оплата', '', $error);
    }
    return trim($error);
});

// Remove rel next\prev links
add_filter( 'wpseo_next_rel_link', '__return_false' );
add_filter( 'wpseo_prev_rel_link', '__return_false' );

// Canonicalize pagination links - point them to the first page
add_filter('wpseo_canonical', function ($link) {

    if(is_paged()) {

        return preg_replace('/\/page\/[0-9]+\/$/', '/', $link);

    }

    return $link;

});

// Remove rss
remove_action('wp_head', 'rest_output_link_wp_head' );
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11 );
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

