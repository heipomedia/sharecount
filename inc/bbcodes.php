<?php
/**
 * Add BBCodes
 */

// BBCode Facebook
function bbcode_facebook() {
    global $post;
	$shares = get_post_meta($post->ID, 'sharecount_facebook', true);

    return empty($shares) ? 0 : $shares;
}
add_shortcode('sharecount_facebook', 'bbcode_facebook');

// BBCode Twitter
function bbcode_twitter() {
    global $post;
	$shares = get_post_meta($post->ID, 'sharecount_twitter', true);

    return empty($shares) ? 0 : $shares;
}
add_shortcode('sharecount_twitter', 'bbcode_twitter');

// BBCode Mail
function bbcode_mail() {
    global $post;
	$shares = get_post_meta($post->ID, 'sharecount_mail', true);

    return empty($shares) ? 0 : $shares;
}
add_shortcode('sharecount_mail', 'bbcode_mail');

// BBCode display buttons
function bbcode_buttons() {
	return sharecount_display();
}
add_shortcode('sharecount_buttons', 'bbcode_buttons');
