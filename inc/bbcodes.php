<?php
/**
 * Add BBCodes
 */

// BBCode Facebook
function sharecount_bbcode_facebook() {
    global $post;
	$shares = get_post_meta($post->ID, 'sharecount_facebook', true);

    return empty($shares) ? 0 : $shares;
}
add_shortcode('sharecount_facebook', 'sharecount_bbcode_facebook');

// BBCode Twitter
function sharecount_bbcode_twitter() {
    global $post;
	$shares = get_post_meta($post->ID, 'sharecount_twitter', true);

    return empty($shares) ? 0 : $shares;
}
add_shortcode('sharecount_twitter', 'sharecount_bbcode_twitter');

// BBCode Mail
function sharecount_bbcode_mail() {
    global $post;
	$shares = get_post_meta($post->ID, 'sharecount_mail', true);

    return empty($shares) ? 0 : $shares;
}
add_shortcode('sharecount_mail', 'sharecount_bbcode_mail');

// BBCode Mail
function sharecount_bbcode_allshares() {
    global $post;
	$shares_facebook = get_post_meta($post->ID, 'sharecount_facebook', true);
	$shares_twitter = get_post_meta($post->ID, 'sharecount_twitter', true);
	$shares_mail = get_post_meta($post->ID, 'sharecount_mail', true);

	$shares = $shares_facebook + $shares_twitter + $shares_mail;

    return empty($shares) ? 0 : $shares;
}
add_shortcode('sharecount_allshares', 'sharecount_bbcode_allshares');

// BBCode display buttons
function sharecount_bbcode_buttons() {
	return sharecount_display();
}
add_shortcode('sharecount_buttons', 'sharecount_bbcode_buttons');
