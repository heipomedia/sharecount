<?php
/**
 * Mail Shares
 */
function sharecount_mail()
{
    // Check if nonce is correct (no abuse)
	if ( ! check_ajax_referer('mail_sharecount_nonce', 'sc_mail_nonce' ) )
		die ( 'Nope');

    // Get post id from ajax
    $post_id = $_REQUEST['post_id'];

    // Bump up mail share counter
    $shares = get_post_meta($post_id, 'sharecount_mail', true);
    $shares = $shares + 1;

    // Update mail share counter
    update_post_meta($post_id, 'sharecount_mail',  $shares);

    // Return the shares to our ajax response
    $shares = empty($shares) ? 0 : $shares;
    echo $shares;

    exit;
}
add_action('wp_ajax_nopriv_sharecount_mail', 'sharecount_mail');
add_action('wp_ajax_sharecount_mail', 'sharecount_mail');
